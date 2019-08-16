@php
    if($centralizado){
        $center_class = 'modal-dialog-centered';
    }
    if($scroll){
        $scroll_class = 'modal-dialog-scrollable';
    }
    if($efeito){
        $efeito_modal = 'fade';
    }
    if($uppercase_titulo){
        $text_transform_class = 'text-uppercase';
    }
@endphp
<div id="{{ $modal_id }}" class="modal {{ $efeito_modal ?? '' }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-{{ $dimensao_modal }} {{ $scroll_class ?? '' }} {{ $center_class ?? '' }}" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning {{ $cor_fonte }}">
                <h5 class="modal-title"><i class="fas fa-bullhorn"></i> Painel de Avisos</h5>
                <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body {{ $cor_fonte }}">
                <div class="container">
                    <div class="">
                        <h4 class="alert-heading {{ $text_transform_class ?? '' }}">{{ $titulo }}</h4>
                          {!! html_entity_decode($conteudo) !!} 
                         {{-- {{ $conteudo ?? '' }} --}}
                         {{-- {!! htmlspecialchars_decode($conteudo) !!} --}}                         
                        {{ $slot }}                        
                    </div>
                </div>
            </div>
            <div class="modal-footer d-none">
                <button class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>