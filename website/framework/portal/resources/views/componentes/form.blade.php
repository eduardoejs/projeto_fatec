@php
    $method = strtolower($method);
    $method_field = "";
    
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

<form action="{{ $action }}" method="{{ $method }}" class="{{ $class ?? '' }}">
    @csrf
    {{ $method_field }}
    {{ $slot }}
</form>
