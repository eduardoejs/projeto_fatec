@extends('layouts.site.admin.app-auth')

@section('content')

@if ($user)
<div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" value="{{$email}}" class="form-control form-control-lg" disabled>
    </div>
    
    <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" name="senha" value="" class="form-control form-control-lg">
    </div>
    
    <div class="form-group">
        <label for="email">Confirme a senha</label>
        <input type="password" value="" class="form-control form-control-lg">
    </div>
    {{-- 
    <div class="form-group">
        <label for="cpf">@php    
        $str = '';
        $posicao = [0,4,8,12];    
        $index = rand(0,3);    
        if($posicao[$index] != 12){
            if($index == 0)
                $str = 'Os 3 primeiros dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 3);
            if($index == 1)
                $str = 'O 4º, 5º e 6º dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 3);
            if($index == 2)
                $str = 'O 7º, 8º e 9º dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 3);
        }else{
            $str = 'Os últimos dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 2);
        }
        echo $str;
    @endphp   </label>
        <input type="number" name="cpf" value="" class="form-control form-control-lg">
    </div>
     --}}
    <button class="btn btn-success btn-block mt-2">ATIVAR CONTA</button>
@else
    <div class="alert alert-danger" role="alert">
            <strong>Dados incorretos!</strong> Não foi possível ativar a conta informada
    </div>
@endif

{{-- 

{{$token}}
{{$email}}
Nova senha:
CPF: {{ $user->cpf }}
@php    
    $str = '';
    $posicao = [0,4,8,12];    
    $index = rand(0,3);    
    if($posicao[$index] != 12){
        if($index == 0)
            $str = 'Os 3 primeiros dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 3);
        if($index == 1)
            $str = 'O 4º,5º e 6º dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 3);
        if($index == 2)
            $str = 'O 7º,8º e 9º dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 3);
    }else{
        $str = 'Os últimos dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 2);
    }
    echo $str;
@endphp    
 --}}
@endsection



