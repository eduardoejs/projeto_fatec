@extends('layouts.site.publico.app', ['exibeMenu' => true])

@section('conteudo')
    <div class="container">
        @if (isset($noticia))
            <div class="jumbotron mt-2">
                <h1>{{$noticia->titulo}}</h1>
                <small class="text-muted">Publicado em: {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y H:i') }}</small>
            </div>
            <div class="media">                
                <div class="media-body text-justify" id="corpo">
                    <img src="{{ url('storage/imagens/noticias/'.$noticia->id.'/thumbnail/medium/'. $noticia->imagens()->where('ordem',1)->first()->nome_arquivo) }}" alt="news" class="">
                    {!! $noticia->conteudo !!}
                </div>
            </div>            
            @card_arquivos_component(['model' => $noticia, 'url' => 'noticia'])
            @endcard_arquivos_component
                       
            <div >
                @foreach ($noticia->imagens as $item)
                    <a class="example-image-link" href="{{ url('storage/imagens/noticias/'.$noticia->id.'/'. $item->nome_arquivo) }}" data-lightbox="roadtrip">
                        <img class="example-image" src="{{ url('storage/imagens/noticias/'.$noticia->id.'/thumbnail/small/'. $item->nome_arquivo) }}">
                    </a>                    
                @endforeach                
            </div>
        @endif
    </div>    
@endsection

@section('css')
    @parent 
    <style>
        #corpo p {
            text-indent: 2em;
        }   
    </style>
    <link rel="stylesheet" href="{{asset('lightbox/dist/css/lightbox.min.css')}}" />    
@endsection

@section('modais')         
@endsection

@section('js')
    <script src="{{ asset('lightbox/dist/js/lightbox-plus-jquery.min.js') }}"></script>    
@endsection