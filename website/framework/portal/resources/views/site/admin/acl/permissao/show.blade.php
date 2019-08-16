@extends('layouts.site.admin.app')

@section('conteudo')

    @page_component(['col' => 12, 'page' => $page])
        
        @pageheader_component(['pagetitle' => $pageHeaderTitle])
            @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
            @endbreadcrumb_component        
        @endpageheader_component
        
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component

        @bodypage_component(['body_title' => $bodyPageTitle, 'body_description' => $bodyPageDescription, 'rotaNome' => $rotaNome, 'page' => $page])
        
            @if ($delete)            
                <h3 class="card-header bg-warning text-black">Exclusão de Registro</h3>
                <div class="card-body">
                    <p class="display-5">Deseja excluir definitivamente o registro abaixo?</p>
                    <h5 class="card-title mb-0">Perfil: {{ $registro->nome }}</h5>
                    <p class="card-text">{{ $registro->descricao }}</p>                    
                    @form_component(['action' => route($rotaNome.'.destroy', $registro->id), 'method' => 'DELETE'])                    
                        <button type="submit" class="btn btn-danger btn-lg float-left"><i class="fa fa-trash-o"></i>Excluir</button>
                    @endform_component
                </div>
            @else                
                <p class="card-text">Descrição: {{ $registro->descricao }}</p>
                <hr>
                
                @if (count($registro->permissoes) > 0)
                    <ul class="list-group">
                        <li class="list-group-item active">Permissões vinculadas ao perfil</li>
                        @foreach ($registro->permissoes as $permissao)
                            <li class="list-group-item">{{ $permissao->descricao }}</li>    
                        @endforeach                        
                      </ul>    
                @else
                    <span class="alert alert-info d-block">Sem permissões vinculadas ao perfil!</span>  
                @endif                
            @endif            

        @endbodypage_component

    @endpage_component
    
@endsection