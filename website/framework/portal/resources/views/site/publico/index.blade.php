@extends('layouts.site.publico.app', ['exibeMenu' => true])

@section('conteudo')
    @include('includes.layout.site.publico.avisos') 
    @include('includes.layout.site.publico.vestibular') 
    @include('includes.layout.site.publico.parallaxTop') 
    @include('includes.layout.site.publico.jumbotron')     
    @include('includes.layout.site.publico.carousel')     
    @include('includes.layout.site.publico.parallaxAlimentos')     
    @include('includes.layout.site.publico.acessoRapido')     
    @include('includes.layout.site.publico.parallaxJIC')    
    @include('includes.layout.site.publico.eventos')    
    @include('includes.layout.site.publico.noticias')    
    @include('includes.layout.site.publico.parallaxMotivacional')            
@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('site/css/navbar/nav.css') }}"> 
@endsection

@section('modais')         
    <!-- Modais -->
        {{-- retorna lista de avisos para montar modais --}}   
        @if ($avisos)
            @foreach ($avisos as $aviso)
                @modal_component(['modal_id' => 'avisoModal'.$aviso->id, //id modal será passado por variavel
                    'efeito' => $efeito, 
                    'dimensao_modal' => $modal_size, //sm lg xl
                    'cor_fonte' => 'text-dark', //color-bg-modal-alert                          
                    'scroll' => $scrolling,
                    'centralizado' => $centralized,
                    'titulo' => $aviso->titulo, //variavel titulo será enviada aqui
                    'uppercase_titulo' => $upper,
                    'conteudo' => $aviso->conteudo
                    ])                        
                @endmodal_component            
            @endforeach  
        @endif        
    <!-- End Modais -->    
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