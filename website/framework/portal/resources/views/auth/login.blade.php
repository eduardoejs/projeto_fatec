@extends('layouts.site.admin.app-auth')

@section('content')
    @form_component(['method' => 'POST', 'action' => route('login'), 'class' => 'user'])
        <div class="form-group">
            <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Endereço de e-mail..." value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" placeholder="Senha" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>        
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Entrar
        </button>
    @endform_component
@endsection
