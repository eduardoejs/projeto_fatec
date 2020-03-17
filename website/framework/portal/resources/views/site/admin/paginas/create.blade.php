@extends('layouts.site.admin.app')
@section('content')
    @page_component(['col' => 12])

        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component        
                
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component
       
        @bodypage_component(['titulo' => $pageTitle, 'descricao' => $pageDescription, 'rotaNome' => $routeName, 'page' => $page])
            @form_component(['action' => route($routeName.'.store'), 'method' => 'POST', 'enctype' => true])
                
                @include('site.admin.'.$pathBlade.'._form')
                
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

@section('css')  
    @parent  
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">      
@stop

@section('js')
    @parent
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script>
        $(function () {
            $(document).ready(function(){
    
                $('[data-toggle="tooltip"]').tooltip()
                $( "#datepicker" ).datepicker({ 
                    minDate: 0, 
                    maxDate: "+12M", 
                    dayNamesMin: [ "D", "S", "T", "Q", "Q", "S", "S" ] ,
                    monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro" ],
                    showAnim: "slideDown",
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    dateFormat: "dd/mm/yy"                    
                });

                CKEDITOR.replace( 'editor', {
                    customConfig: '/ckeditor/custom/ckeditor_config.js'
                });                       
            });            
        })
                
    </script>       
@stop