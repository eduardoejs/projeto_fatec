@extends('layouts.site.admin.app2')

{{--@section('conteudo')
@include('includes.layout.site.admin.pagetitle')
<div class="row">
    <div class="col-md-12 grid-margin">
        @include('includes.layout.site.admin.statistics')
    </div>
    <div class="col-md-12 grid-margin">
        @include('includes.layout.site.admin.e2')
    </div>
</div>            
<div class="row">
    @include('includes.layout.site.admin.panel')  
    @include('includes.layout.site.admin.panel2')
</div>
<div class="row">
    @include('includes.layout.site.admin.panel3')
    <div class="col-md-4">
    @include('includes.layout.site.admin.panel4')
    </div>
</div>
<div class="row">
    @include('includes.layout.site.admin.panel5')
</div>
@endsection--}}

@section('content')

        @include('includes.layout.site.admin.newlayout.pageHeading')
        @include('includes.layout.site.admin.newlayout.cards')
        @include('includes.layout.site.admin.newlayout.charts')
        <!-- Content Row -->
        <div class="row">
            <!-- Content Column -->
            @include('includes.layout.site.admin.newlayout.leftColumn')
            @include('includes.layout.site.admin.newlayout.rigthColumn')            
        </div>
      
@endsection