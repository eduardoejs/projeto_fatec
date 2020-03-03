@extends('layouts.site.admin.app')

@section('content')
      

        @page_component(['col' => 12])
    
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component
    
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component        

        @bodypage_component(['titulo' => $tituloPagina, 'descricao' => $descricaoPagina, 'rotaNome' => $rotaNome, 'page' => $page])
            
        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Cursos cadastrados</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Opções:</div>                        
                        <a href="{{ route($rotaNome.'.create') }}" class="btn btn-outline-success btn-sm btn-icon-split dropdown-item">
                            <span class="icon text-white bg-success">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Adicionar {{ $page }}</span>
                        </a>                                            
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Curso</th>
                                    <th scope="col">Coordenador</th>
                                    <th scope="col">Período</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Modalidade</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cursos as $curso)
                                        <tr>
                                            <th scope="row">{{$curso->id}}</th>
                                            <td>{{$curso->nome}}</td>
                                            <td>@foreach ($curso->getCoordenador($curso->id) as $coordenador)
                                                {{$coordenador->nome}}
                                            @endforeach</td>
                                            <td>{{$curso->periodo}}</td>
                                            <td>{{$curso->tipoCurso->descricao}}</td>
                                            <td>{{$curso->modalidade->descricao}}</td>
                                            <td>@if ($curso->ativo == 'S')
                                                <span class="badge badge-success">Ativo</span>
                                            @else
                                                <span class="badge badge-danger">Inativo</span>
                                            @endif</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-wrench"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton">                                                        
                                                        <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.edit', $curso->id) }}"><i class="fa fa-edit"></i> Editar</a>
                                                        <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.show',[$curso->id, 'delete=true']) }}"><i class="fa fa-trash"></i> Excluir</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.upload.file',[$curso->id]) }}"><i class="fa fa-file"></i> Anexar Arquivos</a>
                                                    </div>
                                                </div> 
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8"><div class="alert alert-primary text-center" role="alert"> Sem registros! </div></td>
                                        </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            </div>
    
            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Tipos de cursos</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="d-none dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Opções:</div>                        
                        {{--  --}}
                        <a href="{{ route($rotaTipo.'.create') }}" class="btn btn-outline-success btn-sm btn-icon-split dropdown-item">
                            <span class="icon text-white bg-success">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Adicionar Tipo</span>
                        </a>  
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Descricao</th>
                                <th class="d-none" scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipos as $tipo)
                                    <tr>
                                        <th scope="row">{{$tipo->id}}</th>
                                        <td>{{$tipo->descricao}}</td>                                        
                                        <td>
                                            <div class="d-none dropdown">
                                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-wrench"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton">                                                    
                                                    <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.edit', $tipo->id) }}"><i class="fa fa-edit"></i> Editar</a>
                                                    <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.show',[$tipo->id, 'delete=true']) }}"><i class="fa fa-trash"></i> Excluir</a>                                                    
                                                </div>
                                            </div> 
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                  </div>
                  <div class="mt-4 text-center small">
                    
                  </div>
                </div>
              </div>
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Modalidades de cursos</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="d-none dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Opções:</div>                        
                        <a href="{{ route($rotaModalidade.'.create') }}" class="btn btn-outline-success btn-sm btn-icon-split dropdown-item">
                            <span class="icon text-white bg-success">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Adicionar Modalidade</span>
                        </a>  
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Descricao</th>
                                <th class="d-none" scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modalidades as $modalidade)
                                    <tr>
                                        <th scope="row">{{$modalidade->id}}</th>
                                        <td>{{$modalidade->descricao}}</td>
                                        
                                        <td>
                                            <div class="d-none dropdown">
                                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-wrench"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton">                                                    
                                                    <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.edit', $modalidade->id) }}"><i class="fa fa-edit"></i> Editar</a>
                                                    <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.show',[$modalidade->id, 'delete=true']) }}"><i class="fa fa-trash"></i> Excluir</a>                                                    
                                                </div>
                                            </div> 
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                  </div>
                  <div class="mt-4 text-center small">
                    
                  </div>
                </div>
              </div>
            </div>
          
            </div>

        @endbodypage_component
    @endpage_component
@endsection
