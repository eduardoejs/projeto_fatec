@if ($items)
    @foreach ($items as $key => $value)
        <div class="col-md-{{$value->col}} grid-margin stretch-card mb-4">
                <a href="{{ $value->route }}" class="text-decoration-none">                          
                <div class="card">
                    <div class="card-body">
                    <h4 class="card-title">{{$value->titulo}}</h4>
                    <div class="media">                        
                        <i class="fa {{$value->icon}} fa-2x text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                        <p class="card-text">{{$value->descricao}}</p>
                        </div>
                    </div>
                    </div>
                </div>
            </a>
        </div>    
    @endforeach    
@endif