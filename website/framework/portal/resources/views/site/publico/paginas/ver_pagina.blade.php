@extends('layouts.site.publico.app', ['exibeMenu' => true])

@section('conteudo')
    <div class="container">
        @if (isset($pagina))
            <div class="text-justify mt-3" id="corpo">                    
                {!! $pagina->conteudo !!}
            </div>            
            @card_arquivos_component(['model' => $pagina, 'url' => 'pagina'])
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