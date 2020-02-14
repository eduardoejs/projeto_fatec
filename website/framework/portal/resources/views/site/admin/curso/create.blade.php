@extends('layouts.site.admin.app')
@section('content')

    @page_component(['col' => 12])            
        
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component        
        
        
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component
       
        @bodypage_component(['titulo' => $tituloPagina, 'descricao' => $descricaoPagina, 'rotaNome' => $rotaNome, 'page' => $page])
            @form_component(['action' => route($rotaNome.'.store'), 'method' => 'POST'])
                @include('site.admin.'.$rotaNome.'._formCurso')
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

@section('js')
    @parent
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $(document).ready(function(){
                CKEDITOR.replace( 'editor', {
                    customConfig: '/ckeditor/custom/ckeditor_config.js'
                });                       
            });            
        })
    </script>       
@stop