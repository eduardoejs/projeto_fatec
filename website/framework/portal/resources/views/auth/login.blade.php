@extends('layouts.site.admin.app-auth')

@section('content')
    
    @form_component(['method' => 'POST', 'action' => route('login'), 'class' => 'form-signin'])
        <div class="form-label-group">
          <input type="email" id="inputEmail" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autofocus>
          <label for="inputEmail">Email</label>
          @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-label-group">
          <input type="password" id="inputPassword" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Senha" required autocomplete="current-password">
          <label for="inputPassword">Senha</label>
          @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit"><i class="fas fa-sign-in-alt"></i> Entrar</button>
        <hr class="my-4">
        <a class="btn btn-sm btn-light btn-block text-uppercase" href="{{ route('password.request') }}"><i class="fab fa-rev"></i> Recuperar minha senha</a>
    @endform_component
    {{--@form_component(['method' => 'POST', 'action' => route('login'), 'class' => 'user'])
        <div class="form-group input-block">
            <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Endereço de e-mail..." value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group input-block">
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
    @endform_component--}}
@endsection
