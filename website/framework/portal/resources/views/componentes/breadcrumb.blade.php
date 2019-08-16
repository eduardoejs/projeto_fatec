@if ($items)
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li><i class="fa fa-home text-primary"></i></li>
            @foreach ($items as $key => $value)
                @if ($value->url)
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ $value->url }}">{{ $value->title }}</a></li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{ $value->title }}</li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif