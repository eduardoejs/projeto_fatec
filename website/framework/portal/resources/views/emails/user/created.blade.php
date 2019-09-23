@component('mail::message')
# Olá, {{ $nome }}.

@component('mail::panel')
Bem-vindo ao portal da {{ config('app.name') }}!<br>
Está tudo pronto para você acessar sua área de usuário.<br>
Para acessar é muito simples, clique no botão abaixo, confirme seus dados, defina uma senha de acesso, e pronto!
@endcomponent

@component('mail::button', ['url' => route('ativar.conta', ['token' => $token, 'email' => $email]), 'color' => 'success'])
ATIVAR MINHA CONTA
@endcomponent

Obrigado,<br>
Equipe TI - {{ config('app.name') }}
@endcomponent