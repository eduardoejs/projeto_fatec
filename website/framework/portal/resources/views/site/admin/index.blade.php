@extends('layouts.site.admin.app')

@section('conteudo')
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
@endsection