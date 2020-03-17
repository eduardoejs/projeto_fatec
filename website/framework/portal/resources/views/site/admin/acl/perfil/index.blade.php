@extends('layouts.site.admin.app')

@section('content')    
    @page_component(['col' => 12])
    
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component
    
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component
        
        @bodypage_component(['titulo' => $tituloPagina, 'descricao' => $descricaoPagina, 'rotaNome' => $rotaNome, 'page' => $page])
            @section('search')
                @busca_component(['rotaNome' => $rotaNome, 'search' => $search, 'page' => $page])
                @endbusca_component                
            @endsection

            @table_component(['colunas' => $colunas, 'list' => $list, 'rotaNome' => $rotaNome, 'page' => $page])
            @endtable_component
        @endbodypage_component
                
    @endpage_component
@endsection