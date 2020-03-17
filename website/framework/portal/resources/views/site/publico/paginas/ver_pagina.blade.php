@extends('layouts.site.publico.app', ['exibeMenu' => true])

@section('conteudo')
    <div class="container">
        @if (isset($pagina))
            <div class="text-justify mt-3" id="corpo">                    
                {!! $pagina->conteudo !!}
            </div>            
            
            @php
                if (Request::segment(2) == 'revista-alimentus' || Request::segment(2) == 'tecnologos-em-foco') {
                    $titulo = 'Edições para download';    
                } else {
                    $titulo = null;
                }                   
            @endphp
                        
            @card_arquivos_component(['model' => $pagina, 'url' => 'pagina', 'titulo' => $titulo])
            @endcard_arquivos_component
            
        @endif
    </div>    
@endsection

@section('css')
    @parent 
    <style>
        #corpo p {
            /*text-indent: 2em;*/
        }   
    </style>
    
@endsection

@section('modais')         
@endsection

@section('js')
    
@endsection