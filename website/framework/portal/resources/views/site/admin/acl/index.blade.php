@extends('layouts.site.admin.app')

@section('content')


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Access Control List</h1>    
    @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
    @endbreadcrumb_component        
</div>  
    
<div class="row">
    @card_menu_component(['items' => $cards ?? []])
    @endcard_menu_component        
</div>
    


@endsection

@section('js')
    <script>
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()          
        })
    </script>    
@endsection