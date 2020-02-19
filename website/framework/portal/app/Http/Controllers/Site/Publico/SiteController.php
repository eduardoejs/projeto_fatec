<?php

namespace App\Http\Controllers\Site\Publico;

use App\Models\Acl\User;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use App\Models\Cursos\TipoCurso;
use App\Models\Cursos\Modalidade;
use App\Http\Controllers\Controller;
use App\Models\Sistema\Avisos\Aviso;
use App\Models\Sistema\Noticias\Noticia;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{   
    private $tipos = null; 
    private $cursos = null; 

    public function __construct()
    {
        $this->tipos = TipoCurso::all();
        $this->cursos = new Curso();
    }

    public function index()
    {        
        $avisos = Aviso::where('data_exibicao','>=', date('Y-m-d'))->get();        
        $efeito = true;
        $modal_size = 'lg';
        $scrolling = false;
        $centralized = true;
        $upper = true;  
               
        $tipos = TipoCurso::all();
        $cursos = new Curso();
        
        //retornar apenas as 3 últimas noticias        
        $noticias = Noticia::with('imagens')->where('ativo','S')->whereRaw('(data_exibicao is null or data_exibicao >= curdate())')->orderBy('id', 'DESC')->take(3)->get();         
            
        return view('site.publico.index', compact('tipos', 'cursos', 'efeito', 'modal_size', 'scrolling', 'centralized', 'upper', 'avisos', 'noticias'));
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

    public function lerNoticia($id)
    {
        $tipos = $this->tipos;
        $cursos = $this->cursos;
        $noticia = Noticia::with('imagens', 'arquivos')->findOrFail($id);
        return view('site.publico.noticias.ler_noticia', compact('tipos', 'cursos', 'noticia'));
    }

    public function verCurso($id)
    {        
        $tipos = $this->tipos;
        $cursos = $this->cursos;
        //$curso = Curso::with('arquivos')->findOrFail($id);
        $curso = Curso::findOrFail($id);
        return view('site.publico.cursos.ver_curso', compact('curso', 'tipos', 'cursos'));
    }
}
