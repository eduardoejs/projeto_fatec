@php
    $itens = 0;
    $deck = "card-deck justify-content-sm-center"  
@endphp

<div class="{{ $deck }}">
    @foreach ($avisos as $aviso)

        @if ($itens % 3 == 0)
            </div>
            <div class="{{ $deck }}">
        @endif    

        <div class="card border-warning mb-2">
            <div class="card-header bg-warning text-uppercase"><i class="fas fa-exclamation"></i> Aviso Importante</div>
            <div class="card-body">
                <h5 class="card-title">{{ $aviso->titulo }}</h5>
                <p class="card-text">{{ $aviso->resumo }}</p>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="h6 text-muted"><small><i class="fas fa-calendar-alt"></i> {{ $aviso->data_criacao }}</small></p>
                    <a href="#" class="btn btn-warning d-block" data-toggle="modal" data-target="#avisoModal{{$aviso->id}}"><i class="far fa-clone"></i> Visualizar</a>
                </div>                
            </div>
        </div>

        @php
            $itens++;
        @endphp
        
    @endforeach
</div>
