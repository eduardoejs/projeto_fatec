<?php

namespace App\Http\Controllers\Site\Publico;


use App\Models\Acl\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sistema\Avisos\Aviso;

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
        
        return view('site.publico.index', compact('efeito', 'modal_size', 'scrolling', 'centralized', 'upper', 'avisos'));
    }
    
    public function showFormAtivacao($token, $email)
    {   
        
        if(isset($token) && isset($email))
        {
            $user = User::where('token', $token)->where('email', $email)->first();            
            if($user){
                return view('site.publico.ativar_usuario', compact('token', 'email', 'user'));
            }else {
                return 'inválido';
            }
        }
    }
}
