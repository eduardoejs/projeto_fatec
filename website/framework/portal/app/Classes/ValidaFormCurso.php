<?php

namespace App\Classes;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ValidaFormCurso 
{
    
    public static function validateForm(Request $request) 
    {        
        $data = $request->all();        
     
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'duracao' => 'required|numeric',
            'qtde_vagas' => 'required|numeric',
            'periodos' => 'required',
            'ativo' => 'required',
            'tipoCurso' => 'required',
            'modalidade' => 'required',
            'coordenador' => 'required',
            'email' => 'required|email|max:255',                
            'conteudo' => 'required',
        ]);         
        return $validator;
    }
}