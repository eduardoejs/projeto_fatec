@if ($avisos)
    <!-- Avisos Importantes -->
    <div class="container">
        <div class="row justify-content-sm-center mt-2">
            @card_aviso_component(['avisos' => $avisos ?? null])
            @endcard_aviso_component
        </div>
    </div>
    <!-- End Avisos Importantes -->    
@endif
