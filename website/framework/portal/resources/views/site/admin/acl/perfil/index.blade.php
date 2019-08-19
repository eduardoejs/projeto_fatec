@extends('layouts.site.admin.app2')

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
            @table_component(['colunas' => $colunas, 'list' => $list, 'rotaNome' => $rotaNome])
            @endtable_component
        @endbodypage_component
                
    @endpage_component
@endsection