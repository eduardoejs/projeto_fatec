<div id="{{ $modal_id }}" {{ $estilos['static'] }} class="modal {{ $estilos['efeito'] }}" tabindex="-1" role="dialog">
    <div class="modal-dialog {{ $estilos['dimensao_modal'] }} {{ $estilos['scroll'] }} {{ $estilos['posicao_modal'] }}" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning {{ $estilos['cor_fonte'] }}">
                <h5 class="modal-title"><i class="fas fa-bullhorn"></i> Painel de Avisos</h5>
                <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body {{ $estilos['cor_fonte'] }}">
                <div class="container">
                    <div class="">
                        <h4 class="alert-heading {{ $estilos['text_transform'] }}">{{ $titulo }}</h4>
                            {!! html_entity_decode($conteudo) !!}                         
                            {{ $slot }}                        
                    </div>
                </div>
            </div>
            <div class="modal-footer {{ $estilos['botao_fechar'] }}">
                <button class="btn btn-light btn-sm" data-dismiss="modal"><i class="far fa-window-close"></i> Fechar</button>
            </div>
        </div>
    </div>
</div>