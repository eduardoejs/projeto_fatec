<div class="card">
    <div class="card-body">        
        <div class="d-flex justify-content-between">
            <div>
                <h2 class="font-weight-bold">{{$titulo}}</h2>
                <p class="card-description">{{$descricao}}</p>
            </div> 
            <div class="align-self-end">
                @hasSection('search')
                    @yield('search')                
                @endif
            </div>               
        </div>        
        {{ $slot }}
    </div>
</div>