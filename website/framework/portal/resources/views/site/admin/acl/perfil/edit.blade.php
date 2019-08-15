@extends('layouts.site.admin.app')
@section('conteudo')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">ACL - Access Control List</h4>
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                <div class=" ml-auto">                    
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('admin') }}"><i class="fa fa-home"></i> Painel Controle</a></li>
                            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('admin.acl') }}">ACL</a></li>
                            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('perfil.index') }}">Perfil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>                
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
    @endalert_component    
</div>

<div class="col-md-12 d-flex align-items-stretch grid-margin">
    <div class="row flex-grow">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Alterar Perfil: {{ $registro->nome }}</h4>
                    <p class="card-description">Descrição: {{ $registro->descricao }} </p>
                    <form action="{{ route('perfil.update', $registro->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('site.admin.acl.perfil._form')
                        <hr>
                        <div class="form-group col-12">
                            <button type="submit" class="btn btn-warning btn-lg"><i class="fa fa-edit"></i>Alterar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection