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
                        <span class="text-danger h5">Deseja excluir definitivamente o registro abaixo?</span>
                        <h5 class="card-title mb-0">Perfil: {{ $registro->nome }}</h5>
                        <p class="card-text">{{ $registro->descricao }}</p>                    
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
                <p class="card-text">Descrição: {{ $registro->descricao }}</p>
                <hr>
                
                @if (count($registro->perfis) > 0)
                    <ul class="list-group">
                        <li class="list-group-item active">Perfis vinculadas a permissão</li>
                        @foreach ($registro->perfis as $perfil)
                            <li class="list-group-item">{{ $perfil->descricao }}</li>    
                        @endforeach                        
                      </ul>    
                @else
                    <span class="alert alert-info d-block">Sem perfil vinculado a permissão!</span>  
                @endif                
            @endif            

        @endbodypage_component

    @endpage_component
    
@endsection