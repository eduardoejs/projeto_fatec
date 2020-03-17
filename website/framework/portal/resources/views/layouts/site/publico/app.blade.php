<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!--<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        
    <!-- CSS Custom -->    
    @section('css')
      <link rel="stylesheet" href="{{ asset('site/css/navbar/nav.css') }}"> 
      <link rel="stylesheet" href="{{ asset('site/css/style.css') }}">
    @show
        
    <!-- Icons FontAwesome-->
    <!--<link rel="stylesheet" href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">

    <!-- Font Style -->
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif%7CUbuntu" rel="stylesheet">

    <title>{{ config('app.name') }}</title>
  </head>
  <body>  
    
    @include('includes.layout.site.publico.logoSuperior')         
    @includeWhen($exibeMenu, 'includes.layout.site.publico.navBar')
        
    @yield('conteudo')
    
    @include('includes.layout.site.publico.rodape')

    @section('modais')        
    @show
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('site/js/navbar/nav.js') }}"></script>     
    
    @section('js')
    @show

  </body>
</html>