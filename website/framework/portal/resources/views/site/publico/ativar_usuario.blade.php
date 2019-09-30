@extends('layouts.site.admin.app-auth')

@section('content')

@alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
@endalert_component

@if ($user)
<form action="{{ route('validar.conta') }}" method="POST">
    @csrf
    <input type="hidden" name="token_create" value="{{$token}}">
    
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" value="{{$email}}" class="form-control form-control-lg" readonly>
        </div>
        
        <div class="form-group">
            <label for="senha">Defina uma senha</label>
            <input type="password" id="password" name="password" class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        
        <div class="form-group">
            <label for="email">Confirme a senha</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" required>
                @if ($errors->has('password_confirmation'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif            
        </div>        
        
        <button type="submit" class="btn btn-success btn-block">ATIVAR CONTA</button>
        
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
        
</form>

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



