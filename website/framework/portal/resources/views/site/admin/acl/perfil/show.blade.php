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
                                <li class="breadcrumb-item active" aria-current="page">Delete</li>                
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">            
        <div class="card">
            <h3 class="card-header bg-warning text-black">Exclusão de Registro</h3>
            <div class="card-body">
                <p class="display-5">Deseja excluir definitivamente o registro abaixo?</p>
                <h5 class="card-title mb-0">{{ $registro->nome }}</h5>
                <p class="card-text">{{ $registro->descricao }}</p>
                    <form action="{{ route('perfil.destroy', $registro->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-lg"><i class="fa fa-trash-o"></i>Excluir</button>
                </form>              
            </div>
          </div>
    </div>
    
@endsection