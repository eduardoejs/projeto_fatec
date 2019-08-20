<form class="form-inline" method="GET" action="{{ route($rotaNome.'.index') }}">
    <div class="form-group mb-2">
        {{--@can('add-user')--}}
        <a href="{{ route($rotaNome.'.create') }}" class="btn btn-outline-success btn-sm btn-icon-split">
            <span class="icon text-white bg-success">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Adicionar {{ $page }}</span>
        </a>            
        {{--@endcan--}}
    </div>
    
    <div class="form-group mx-sm-3 mb-2">
        <input type="search" class="form-control form-control-sm" placeholder="Pesquisar..." name="search" value="{{ $search }}">
    </div>
    <button type="submit" class="btn btn-outline-primary btn-sm mb-2"><i class="fa fa-search" aria-hidden="true"></i> </button>
    <a href="{{ route($rotaNome.'.index') }}" class="btn btn-outline-secondary btn-sm mb-2 ml-1"><i class="fa fa-broom" aria-hidden="true"></i></a>

</form>