@foreach ($avisos as $aviso)
    <div class="col-sm-6 col-md-4">
        <div class="card border-warning mb-2">
            <div class="card-header bg-warning text-uppercase"><i class="fas fa-exclamation"></i> Aviso Importante</div>
            <div class="card-body ">
                <h5 class="card-title">{{$aviso->titulo}}</h5>
                <p class="card-text">{{$aviso->resumo}}</p>
                <a href="#" class="btn btn-outline-warning d-block text-dark" data-toggle="modal" data-target="#avisoModal{{$aviso->id}}">Clique aqui para ver o aviso</a>
            </div>
        </div>            
    </div>
@endforeach
