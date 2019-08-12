<?php

namespace App\Http\Controllers\Site\Publico;


use App\Models\Sistema\Avisos\Aviso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    
}
