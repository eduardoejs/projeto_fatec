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
            @form_component(['action' => route($rotaNome.'.update', $registro->id), 'method' => 'PUT'])
                @include('site.admin.acl.'.$rotaNome.'._form')
                <button type="submit" class="btn btn-success btn-lg float-right"><i class="fa fa-edit"></i>Alterar</button>
            @endform_component
        @endbodypage_component

@endpage_component
    
@endsection