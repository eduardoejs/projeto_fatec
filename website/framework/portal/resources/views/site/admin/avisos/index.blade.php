@extends('layouts.site.admin.app')

@section('content')    
    @page_component(['col' => 12])
    
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component
    
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component

        @bodypage_component(['titulo' => $pageTitle, 'descricao' => $pageDescription, 'rotaNome' => $routeName, 'page' => $page])
            @section('search')
                @busca_component(['rotaNome' => $routeName, 'search' => $search, 'page' => $page])
                @endbusca_component                
            @endsection
            
            @table_component(['colunas' => $columnsTable, 'list' => $list, 'rotaNome' => $routeName, 'page' => $page])            
            @endtable_component
            
            {{ $list->appends(request()->query())->links() }}                        
        @endbodypage_component
                
    @endpage_component
@endsection

