@if ($avisos)
    <!-- Avisos Importantes -->
    <div class="container">        
        @card_aviso_component(['avisos' => $avisos ?? null])
        @endcard_aviso_component
    </div>
    <!-- End Avisos Importantes -->    
@endif
