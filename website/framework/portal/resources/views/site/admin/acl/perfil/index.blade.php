@extends('layouts.site.admin.app')

@section('conteudo')    
    @page_component(['col' => 12, 'page' => $page])
        
        @pageheader_component(['pagetitle' => $pageHeaderTitle]) 
            @section('search')
                @busca_component(['rotaNome' => $rotaNome, 'search' => $search, 'page' => $page])
                @endbusca_component                
            @endsection       
            @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
            @endbreadcrumb_component        
        @endpageheader_component
        
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component

        @bodypage_component(['body_title' => $bodyPageTitle, 'body_description' => $bodyPageDescription, 'rotaNome' => $rotaNome, 'page' => $page])
            @table_component(['colunas' => $colunas, 'list' => $list, 'rotaNome' => $rotaNome])
            @endtable_component
        @endbodypage_component
                
    @endpage_component
@endsection