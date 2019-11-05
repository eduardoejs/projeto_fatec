@extends('layouts.site.publico.app')

@section('conteudo')
    <div class="container">
        @if (isset($noticia))
            <div class="jumbotron mt-2">
                    <h1>{{$noticia->titulo}}</h1>
                    <small class="text-muted">Publicado em: {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y H:i') }}</small>
            </div>
            
            <div class="text-justify" id="corpo">
                {!! $noticia->conteudo !!}
            </div>
        @endif
    </div>    
@endsection

@section('css')
    @parent 
    <style>
    #corpo p {
        text-indent: 4em;
    }   
    </style>
@endsection

@section('modais')         
    
        
@endsection

@section('js')
    <script>
        $('.carousel').carousel({
            interval: 3000,
            pause: false
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $(function(){
            $('[data-toggle="popover"]').popover()
        }); 
    </script>    
@endsection