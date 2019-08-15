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
    
    <div class="alert alert-{{ $status }} alert-dismissible fade show" role="alert">        
        @if ($title)
            <h4 class="alert-heading">{{ $title }}</h4>
        @endif        
        <p>{{ $msg }}</p>        
    </div>
@endif