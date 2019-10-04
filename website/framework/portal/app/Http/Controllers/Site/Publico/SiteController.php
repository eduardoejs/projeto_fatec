<?php

namespace App\Http\Controllers\Site\Publico;


use App\Models\Acl\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sistema\Avisos\Aviso;
use App\Models\Sistema\Noticias\Noticia;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {        
        $avisos = Aviso::where('data_exibicao','>=', date('Y-m-d'))->get();        
        $efeito = true;
        $modal_size = 'lg';
        $scrolling = false;
        $centralized = true;
        $upper = true;  
        
        //retornar apenas as 3 ultimas noticias
        $noticias = Noticia::all();        
        
        return view('site.publico.index', compact('efeito', 'modal_size', 'scrolling', 'centralized', 'upper', 'avisos', 'noticias'));
    }
    
    public function showFormAtivacao($token, $email)
    {           
        if(isset($token) && isset($email)) {
            $user = User::where('token_create', $token)->where('email', $email)->first();            
            if($user) {
                if(md5($user->cpf) == $token){                    
                    return view('site.publico.ativar_usuario', compact('token', 'email', 'user'));
                }                
            }else {
                
                session()->flash('msg', 'Erro ao localizar usuário!');
                session()->flash('status', 'error');
                return view('site.publico.ativar_usuario', compact('token', 'email', 'user'));
            }
        }
    }

    public function validarConta(Request $request)
    {    
        $rules = [
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);
            
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator->messages())
                        ->withInput();   
        }
        
        if(isset($request->token_create) && isset($request->email)) {            
            $user = User::where('token_create', $request->token_create)->where('email', $request->email)->first();            
            if($user) {                
                if(md5($user->cpf) == $request->token_create){ 
                    $user->update(['password' => bcrypt($request->password)]);                    
                }else{
                    session()->flash('msg', 'Erro ao processar token de validação!');
                    session()->flash('status', 'error');
                    return redirect()->back();
                }
            } else {
                session()->flash('msg', 'Erro ao processar localizar usuário!');
                session()->flash('status', 'error');
                return redirect()->back();
            }
        }
        return redirect()->route('admin');
    }    
}
