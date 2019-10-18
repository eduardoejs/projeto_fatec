@extends('layouts.site.admin.app')
@section('content')

    @page_component(['col' => 12])                
        
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component  
        
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component

        @bodypage_component(['titulo' => $tituloPagina, 'descricao' => $descricaoPagina, 'rotaNome' => $rotaNome, 'page' => $page])
            @form_component(['action' => route($rotaNome.'.update', $registro->id), 'method' => 'PUT'])
                @include('site.admin.acl.'.$rotaNome.'._form')                
                <button type="submit" class="btn btn-outline-success float-right btn-icon-split">
                    <span class="icon text-white bg-success">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text">Gravar</span>
                </button> 
            @endform_component
        @endbodypage_component

@endpage_component
    
@endsection