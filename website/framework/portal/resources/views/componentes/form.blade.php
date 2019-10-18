@php
    $method = strtolower($method);
    $method_field = "";
    
    if(isset($enctype) && $enctype) {
        $enctype = 'enctype="multipart/form-data"';        
    }
    
    if($method == 'post') {

    } elseif($method == 'put') {
        $method = 'post';
        $method_field = method_field('PUT'); // @method('PUT')
    } elseif($method == 'delete') {
        $method = 'post';
        $method_field = method_field('DELETE'); // @method('DELETE')
    } else {
        $method = 'get';
    }
@endphp

<form action="{{ $action }}" method="{{ $method }}" class="{{ $class ?? '' }}" {!! $enctype ?? '' !!}>
    @csrf
    {{ $method_field }}
    {{ $slot }}
</form>
