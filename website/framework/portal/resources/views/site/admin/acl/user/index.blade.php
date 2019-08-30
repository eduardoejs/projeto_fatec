@extends('layouts.site.admin.app')

@section('content')    
    @page_component(['col' => 12])
    
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component
    
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component
        
        @section('search')
            @busca_component(['rotaNome' => $rotaNome, 'search' => $search, 'page' => $page])
            @endbusca_component            
        @endsection          

        @bodypage_component(['titulo' => $tituloPagina, 'descricao' => $descricaoPagina, 'rotaNome' => $rotaNome, 'page' => $page])
            
        <div class="row float-right">
                <div class="input-group mb-3">
                    <select class="custom-select" id="inputGroupSelect02">
                        <option selected>Funcionarios</option>
                        <option value="1">Alunos</option>
                        <option value="2">Docentes</option>
                        <option value="3">ExAlunos</option>
                    </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02"><i class="fa fa-filter" aria-hidden="true"></i>Filtro</label>
                </div>
                </div>            
        </div>
            @table_component(['colunas' => $colunas, 'list' => $list, 'rotaNome' => $rotaNome])
            @endtable_component
        @endbodypage_component
                
    @endpage_component
@endsection