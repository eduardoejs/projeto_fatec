@extends('layouts.site.admin.app')

@section('content')

    @page_component(['col' => 12])
                
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component
        
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component

        @bodypage_component(['titulo' => $pageTitle, 'descricao' => $pageDescription, 'rotaNome' => $routeName, 'page' => $page])
        
            @if ($delete)  
                <div class="card border-warning mb-3">
                    <h3 class="card-header bg-warning text-dark"><i class="fa fa-exclamation"></i> Atenção</h3>
                    <div class="card-body">
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Informação importante</h4>
                            <p>Ao excluir um aviso do sistema, não será possível sua recuperação.</p>
                            <hr>
                            <p class="mb-0">Se você estiver de acordo, prossiga com a operação de exclusão!</p>
                        </div>
                        <span class="text-danger h5">Deseja excluir definitivamente o registro abaixo?</span>
                        <h5 class="card-title mt-3 mb-0">Aviso: {{ $registro->titulo }}</h5> 
                        <hr>
                        <span>{!! $registro->conteudo !!}</span>
                        
                        @form_component(['action' => route($routeName.'.destroy', $registro->id), 'method' => 'DELETE'])                            
                            <button type="submit" class="btn btn-outline-danger float-left btn-icon-split mt-2">
                                    <span class="icon text-white bg-danger">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Excluir</span>
                                </button> 
                        @endform_component
                    </div>
                </div>          
            @else                
                <p>Resumo: {{ $registro->resumo }}</p> 
                <hr>               
                <p>{!! $registro->conteudo !!}</p>
            @endif            
        @endbodypage_component
    @endpage_component    
@endsection