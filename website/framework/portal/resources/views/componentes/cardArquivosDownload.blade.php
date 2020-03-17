@if ($model)
    @if (count($model->arquivos) > 0)
        <div class="card border-dark mt-3 mb-3">
            <div class="card-header"><i class="fas fa-file-download"></i> {{ $titulo ?? 'Arquivos para download' }}</div>
            <div class="card-body text-dark">                
                @foreach ($model->arquivos()->orderBy('created_at', 'desc')->get() as $arquivo)
                    <div class="list-group mb-1">
                        <a href="{{ route('site.'. $url .'.download.file', ['id' => $model->id, 'fileId' => $arquivo->id]) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{$arquivo->titulo}}</h5>
                            <small><i class="far fa-calendar-alt"></i> {{ Carbon\Carbon::parse($arquivo->created_at)->format('d/m/Y H:i:s') }}</small>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <small>{{$arquivo->descricao}}</small>
                            <i class="fas fa-download"></i>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif    
@endif
