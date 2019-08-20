@extends('layouts.site.admin.app')

@section('content')

        @include('includes.layout.site.admin.pageHeading')
        @include('includes.layout.site.admin.cards')
        @include('includes.layout.site.admin.charts')
        <!-- Content Row -->
        <div class="row">
            <!-- Content Column -->
            @include('includes.layout.site.admin.leftColumn')
            @include('includes.layout.site.admin.rigthColumn')            
        </div>
      
@endsection