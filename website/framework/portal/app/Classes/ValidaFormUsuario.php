<?php

namespace App\Classes;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ValidaFormUsuario {

    private static function getTipoUsuario(Request $request) 
    {
        $data = [];

        foreach ($request->selectTipo as $key => $value) {
            switch ($value) {
                case 'F':
                    $data += $request->except(['cargo_docente', 'titulacao', 'lattes_docente', 'link_compartilhado', 'exibe_dados_docente', 'matricula', 'curso']);
                break;
                case 'D':
                    $data += $request->except(['cargo_funcionario', 'departamento_funcionario', 'matricula', 'exibe_dados_funcionario', 'lattes_funcionario', 'curso']);
                break;
                case 'A':
                case 'EX':
                    $data += $request->except(['cargo_funcionario', 'departamento_funcionario', 'cargo_docente', 'titulacao', 'lattes_docente', 'exibe_dados_docente', 'exibe_dados_funcionario', 'lattes_funcionario', 'link_compartilhado']);
                break;
                default:
                    $data += $request->except(['cargo_funcionario', 'departamento_funcionario', 'cargo_docente', 'titulacao', 'lattes_docente', 'exibe_dados_docente', 'exibe_dados_funcionario', 'lattes_funcionario', 'link_compartilhado', 'matricula', 'curso']);
                break;
            }
        }
        return $data;
    }

    public static function validateForm(Request $request, $id = null) 
    {
        //1º - Saber que tipo de dados validar
        $data = self::getTipoUsuario($request);
        
        //2º Validar o request
        foreach ($request->selectTipo as $key => $value) {
            if($value == 'A' || $value == 'EX') {
                if($id == null){
                    $validator = Validator::make($data, [
                        'nome' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:users',
                        'password' => 'required|string|min:6',
                        'cpf' => 'required|string|unique:users',
                        'selectTipo' => 'required',
                        'sexo' => 'required',
                        'telefone' => 'nullable|string',
                        'ativo' => 'required',
                        'matricula' => 'required|max:15',                
                        'curso' => 'required',
                    ]);
                }else{                    
                    $validator = Validator::make($data, [
                        'nome' => 'required|string|max:255',
                        'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($id)],
                        'password' => 'sometimes|required|string|min:6',
                        'cpf' => ['required','string', Rule::unique('users')->ignore($id)],
                        'selectTipo' => 'required',
                        'sexo' => 'required',
                        'telefone' => 'nullable|string',
                        'ativo' => 'required',
                        'matricula' => 'required|max:15',                
                        'curso' => 'required',
                    ]);
                }
            } else if($value == 'F') { 
                if($id == null) {               
                    $validator = Validator::make($data, [
                        'nome' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:users',
                        'password' => 'required|string|min:6',
                        'cpf' => 'required|string|unique:users',
                        'selectTipo' => 'required',
                        'sexo' => 'required',
                        'telefone' => 'nullable|string',
                        'ativo' => 'required',
                        'lattes_funcionario' => 'nullable|url',                
                    ]);
                } else {
                    $validator = Validator::make($data, [
                        'nome' => 'required|string|max:255',
                        'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($id)],
                        'password' => 'sometimes|required|string|min:6',
                        'cpf' => ['required','string', Rule::unique('users')->ignore($id)],
                        'selectTipo' => 'required',
                        'sexo' => 'required',
                        'telefone' => 'nullable|string',
                        'ativo' => 'required',
                        'lattes_funcionario' => 'nullable|url',                
                    ]);
                }
            } else if($value == 'D'){
                if($id == null) {
                    $validator = Validator::make($data, [
                        'nome' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:users',
                        'password' => 'required|string|min:6',
                        'cpf' => 'required|string|unique:users',
                        'selectTipo' => 'required',
                        'sexo' => 'required',
                        'telefone' => 'nullable|string',
                        'ativo' => 'required',
                        'lattes_docente' => 'nullable|url',                
                    ]);
                } else {
                    $validator = Validator::make($data, [
                        'nome' => 'required|string|max:255',
                        'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($id)],
                        'password' => 'sometimes|required|string|min:6',
                        'cpf' => ['required','string', Rule::unique('users')->ignore($id)],
                        'selectTipo' => 'required',
                        'sexo' => 'required',
                        'telefone' => 'nullable|string',
                        'ativo' => 'required',
                        'lattes_docente' => 'nullable|url',                
                    ]);
                }
            } else {
                if($id == null) {
                    $validator = Validator::make($data, [
                        'nome' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:users',
                        'password' => 'required|string|min:6',
                        'cpf' => 'required|string|unique:users',
                        'selectTipo' => 'required',
                        'sexo' => 'required',
                        'telefone' => 'nullable|string',
                        'ativo' => 'required',                    
                    ]);
                } else {
                    $validator = Validator::make($data, [
                        'nome' => 'required|string|max:255',
                        'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($id)],
                        'password' => 'sometimes|required|string|min:6',
                        'cpf' => ['required','string', Rule::unique('users')->ignore($id)],
                        'selectTipo' => 'required',
                        'sexo' => 'required',
                        'telefone' => 'nullable|string',
                        'ativo' => 'required',                    
                    ]);
                }
            } 
        }

        return $validator;
    }

}