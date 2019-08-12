<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!--<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
    <!-- CSS Custom -->    
    @section('css')
        <link rel="stylesheet" href="{{ asset('site/css/style.css') }}">
    @show
        
    <!-- Icons FontAwesome-->
    <!--<link rel="stylesheet" href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- Font Style -->
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif%7CUbuntu" rel="stylesheet">

    <title>{{ config('app.name') }}</title>
  </head>
  <body>  

    @php
        $exibeMenu = true;
    @endphp

    @include('includes.layout.site.publico.logoSuperior')
    @includeWhen($exibeMenu, 'includes.layout.site.publico.navBar')
    
    @yield('conteudo')
    
    @include('includes.layout.site.publico.rodape')

    @section('modais')        
    @show
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <script src="{{ asset('site/js/menu.js') }}"></script>
    @section('js')
    @show

  </body>
</html>