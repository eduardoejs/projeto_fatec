<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <span>
                <h2 class="font-weight-semibold">{{$body_title}}</h2>
                <p class="card-description">{{$body_description}}</p>
            </span>            
            @section('search')
                
            @show
        </div>
        {{ $slot }}
    </div>
</div>