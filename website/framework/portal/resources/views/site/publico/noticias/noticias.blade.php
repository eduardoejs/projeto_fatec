@extends('layouts.site.publico.app', ['exibeMenu' => true])

@section('conteudo')
    <div class="container"> 
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Notícias da Fatec Marília</h1>
                <p class="lead">Veja todas as notícias que a Fatec Marília fez parte.</p>
            </div>
        </div>
        @foreach ($noticias as $noticia)
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">                    
                    @if (isset($noticia->imagens()->where('ordem', 1)->first()->nome_arquivo))
                        <img src="{{ url('storage/imagens/noticias/'.$noticia->id.'/thumbnail/medium/'. $noticia->imagens()->where('ordem',1)->first()->nome_arquivo) }}" alt="news" class="card-img-top img-fluid img-thumbnail">
                    @else
                        <img src="{{ url('storage/imagens/default/no_image.jpeg') }}" alt="news" class="card-img-top img-fluid img-thumbnail">        
                    @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $noticia->titulo }}</h5>
                            <p class="card-text">{!! $noticia->conteudo_resumido !!}</p>
                            <div class="row d-flex flex-row">
                                <div class="col d-flex align-items-center justify-content-center">
                                    <p class="card-text"><small class="text-muted">Publicado em: {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y H:i:s') }}</small></p>
                                </div>
                                <div class="col">
                                    <a href="{{ route('ler.noticia', ['id' => $noticia->id]) }}" class="card-link btn btn-outline-info d-block">Leia mais</a>
                                </div>
                            </div>                                                
                        </div>
                    </div>
                </div>
            </div>            
        @endforeach
        {{ $noticias->links() }}
    </div>    
@endsection

@section('css')
    @parent 
    <style>
        #corpo p {
            text-indent: 2em;
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