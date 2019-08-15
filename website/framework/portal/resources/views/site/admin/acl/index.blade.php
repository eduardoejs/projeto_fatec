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
                                <li class="breadcrumb-item active" aria-current="page">ACL</li>                
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <a href="{{ route('perfil.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-0">Gerenciar</h4>                    
                            <span class="badge badge-pill badge-primary"><i class="fa fa-sign-in"></i> Acessar</span>
                        </div>
                            <h4 class="font-weight-medium mb-4 text-black">Perfil de usuário do sistema</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <i class="fa fa-vcard-o fa-5x text-primary"></i>
                                <p class="card-text text-muted ml-2">Adicione, visualize, altere e exclua os perfis de usuários do sistema.</p>
                            </div>                
                        </div>
                    </div>
                </div>
            </a>
        <div class="col-md-4 grid-margin stretch-card">
            <a href="{{ route('permissao.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-0">Gerenciar</h4>                    
                            <span class="badge badge-pill badge-primary"><i class="fa fa-sign-in"></i> Acessar</span>
                        </div>
                        <h4 class="font-weight-medium mb-4 text-black">Permissões do sistema</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <i class="fa fa-unlock-alt fa-5x text-primary"></i>                    
                            <p class="card-text text-muted ml-2">Adicione, visualize, altere e exclua as permissões do sistema.</p>
                        </div>                
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <a href="{{ route('user.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-0">Gerenciar</h4>                    
                            <span class="badge badge-pill badge-primary"><i class="fa fa-sign-in"></i> Acessar</span>
                        </div>
                        <h4 class="font-weight-medium mb-4 text-black">Usuários do sistema</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <i class="fa fa-user-o fa-5x text-primary"></i>
                            <p class="card-text text-muted ml-2">Adicione, visualize, altere e exclua os dados dos usuários do sistema.</p>
                        </div>                
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Gerenciar</h4>                    
                        <span class="badge badge-pill badge-primary"><i class="fa fa-sign-in"></i> Acessar</span>
                    </div>
                    <h4 class="font-weight-medium mb-4 text-black">Vincular Permissões com Perfil</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-retweet fa-5x text-primary"></i>
                        <p class="card-text text-muted ml-2">Vincula Permissões ao deteminado Perfil de usuário do sistema.</p>
                    </div>                
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Gerenciar</h4>                    
                        <span class="badge badge-pill badge-primary"><i class="fa fa-sign-in"></i> Acessar</span>
                    </div>
                    <h4 class="font-weight-medium mb-4 text-black">Vincular Perfil com Usuário</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-retweet fa-5x text-primary"></i>
                        <p class="card-text text-muted ml-2">Vincula um ou mais Perfis com um usuário do sistema.</p>
                    </div>                
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()          
        })
    </script>    
@endsection