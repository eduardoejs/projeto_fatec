@extends('layouts.site.publico.app', ['exibeMenu' => true])

@section('conteudo')
    <div class="container">
        @if (isset($noticia))                        
            <img class="float-right ml-2 img-thumbnail" src="{{ url('storage/imagens/noticias/'.$noticia->id.'/thumbnail/medium/'. $noticia->imagens()->where('ordem',1)->first()->nome_arquivo) }}" alt="news">
                <h1>{{$noticia->titulo}}</h1>
                <small class="text-muted">Publicado em: {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y H:i') }}</small>
            <div class="text-justify mt-3" id="corpo">                    
                {!! $noticia->conteudo !!}
            </div>
            
            @card_arquivos_component(['model' => $noticia, 'url' => 'noticia'])
            @endcard_arquivos_component
              
            @if (count($noticia->imagens) > 1)
                <div class="card border-dark mb-3">
                    <div class="card-header">
                        <i class="far fa-images"></i> Galeria de imagens
                    </div>
                    <div class="card-body text-center">
                        @foreach ($noticia->imagens as $item)
                            <a class="example-image-link" href="{{ url('storage/imagens/noticias/'.$noticia->id.'/'. $item->nome_arquivo) }}" data-lightbox="roadtrip">
                                <img class="example-image" src="{{ url('storage/imagens/noticias/'.$noticia->id.'/thumbnail/small/'. $item->nome_arquivo) }}">
                            </a>                    
                        @endforeach            
                    </div>    
                </div>    
            @endif
            
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