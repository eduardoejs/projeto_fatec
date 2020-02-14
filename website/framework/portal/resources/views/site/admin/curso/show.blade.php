@extends('layouts.site.admin.app')

@section('content')

    @page_component(['col' => 12])
                
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component
        
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component

        @bodypage_component(['titulo' => $tituloPagina, 'descricao' => $descricaoPagina, 'rotaNome' => $rotaNome, 'page' => $page])
        
            @if ($delete)  
                <div class="card border-warning mb-3">
                    <h3 class="card-header bg-warning text-dark"><i class="fa fa-exclamation"></i> Atenção</h3>
                    <div class="card-body">
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Informação importante</h4>
                            <p>Ao excluir um curso do sistema, todas as informações vinculadas à ele ou relacionadas com outros recursos serão excluídas automaticamente não sendo possível sua recuperação.</p>
                            <hr>
                            <p class="mb-0">Se você estiver de acordo, prossiga com a operação de exclusão!</p>
                        </div>
                        <span class="text-danger h5">Deseja excluir definitivamente o registro abaixo?</span>
                        <h5 class="card-title mt-3 mb-0">Curso: {{ $registro->nome }}</h5>                        
                        <p class="mb-0">Coordenador: {{ $registro->getCoordenador($registro->id)->first()->nome }}</p>
                        <p class="mb-0">E-mail: {{ $registro->email_coordenador }}</p>
                        <p class="mb-0">Tipo: {!! $registro->tipoCurso->descricao !!}</p>
                        <p class="mb-0">Modalide: {!! $registro->modalidade->descricao !!}</p>
                        
                        @form_component(['action' => route($rotaNome.'.destroy', $registro->id), 'method' => 'DELETE'])                            
                            <button type="submit" class="btn btn-outline-danger float-left btn-icon-split">
                                    <span class="icon text-white bg-danger">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Excluir</span>
                                </button> 
                        @endform_component
                    </div>
                </div>          
            @else                
                <p class="card-text">Dados do usuário:</p>
                <p>CPF: {{ $registro->cpf }}</p>
                <p>Telefone: {{ $registro->telefone }}</p>
                <p>Sexo: {{ $registro->sexo }}</p>
                <p>E-mail: {{ $registro->email }}</p>
                <p>Permite Login: {{ $registro->ativo }}</p>
                <p>Currículo Lattes: {{ $registro->url_lattes }}</p>
                <p>Tipo de usuário:</p>                
                @foreach ($registro->tipoUserArray as $item)
                    <span class="badge badge-pill badge-secondary">{{ $item->valor }}</span>
                @endforeach
                <hr>
                @if (count($registro->perfis) > 0)
                    <ul class="list-group">
                        <li class="list-group-item active">Perfis vinculados ao usuário</li>
                        @foreach ($registro->perfis as $perfil)
                            <li class="list-group-item">{{ $perfil->descricao }}</li>    
                        @endforeach
                      </ul>    
                @else
                    <span class="alert alert-info d-block">Sem perfil vinculado ao usuário!</span>  
                @endif                
            @endif            

        @endbodypage_component

    @endpage_component
    
@endsection