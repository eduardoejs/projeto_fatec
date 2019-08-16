<form class="form-inline" method="GET" action="{{ route($rotaNome.'.index') }}">
    <div class="form-group mb-2">
        {{--@can('add-user')--}}
            <a class="btn btn-success" href="{{ route($rotaNome.'.create') }}"><i class="fa fa-plus"></i>Novo {{ $page }}</a>
        {{--@endcan--}}
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <input type="search" class="form-control" placeholder="Pesquisar..." name="search" value="{{ $search }}">
    </div>
    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search" aria-hidden="true"></i> </button>
    <a href="{{ route($rotaNome.'.index') }}" class="btn btn-secondary mb-2 ml-1"><i class="fa fa-refresh" aria-hidden="true"></i></a>
</form>