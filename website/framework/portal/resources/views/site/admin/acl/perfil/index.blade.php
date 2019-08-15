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
                            <li class="breadcrumb-item active" aria-current="page">Perfil</li>                
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

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                        <span>
                            <h2 class="font-weight-semibold">Perfil de Usuário</h2>
                            <p class="card-description">Gerenciamento dos perfis de usuários do sistema</p>
                        </span>
                    <p class="font-weight-semibold mb-0"><a href="{{ route('perfil.create') }}" class="btn btn-primary"><i class="fa fa-plus-square-o"></i> Novo Perfil</a></p>
                </div>
                
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TAG</th>
                            <th>Descrição</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perfis as $perfil)
                            <tr>
                                <td>{{ $perfil->id }}</td>
                                <td>{{ $perfil->nome }}</td>
                                <td>{{ $perfil->descricao }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-inverse-primary dropdown-toggle btn-md" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-wrench"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('perfil.edit', $perfil->id) }}"><i class="fa fa-edit"></i> Editar</a>
                                            <a class="dropdown-item" href="{{ route('perfil.show',[$perfil->id, 'delete=true']) }}"><i class="fa fa-trash-o"></i> Excluir</a>                                            
                                        </div>
                                    </div>
                                </td>                            
                            </tr> 
                            @empty
                            nada                           
                        @endforelse                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    
@endsection