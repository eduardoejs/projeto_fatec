@if ($msg)
    @php
        if($status == 'error') {
            $status = 'danger';
        } elseif($status == 'alert') {
            $status = 'warning';
        } elseif($status == 'notification') {
            $status = 'info';
        } else {
            $status = 'success';
        }
    @endphp    
    
    <div class="alert alert-{{ $status }}" role="alert">        
        @if ($title)
            <h4 class="alert-heading">{{ $title }}</h4>
        @endif        
        {{ $msg }}
    </div>
@endif