@extends('layouts.site.admin.app')

{{-- https://github.com/techlab/SmartWizard --}}

@section('css')
    
@endsection

@section('js')
    <script>        
        $('#tipoFuncionario').css('display', 'none')        

        $(document).ready(function(){
            $('#selecionaTipo').change(function() {
                //console.log($(this).val())
                if($(this).val() == 'F'){
                    $('#tipoFuncionario').css('display', 'block')
                } else {
                    $('#tipoFuncionario').css('display', 'none')
                }
                if($(this).val() == 'D'){
                    $('#tipoDocente').css('display', 'block')
                } else {
                    $('#tipoDocente').css('display', 'none')
                }
                if( ($(this).val() == 'A') || ($(this).val() == 'EX')){
                    $('#tipoAluno').css('display', 'block')
                } else {
                    $('#tipoAluno').css('display', 'none')
                }
            });
            //Masks
            $('.cpf').mask('000.000.000-00', {reverse: true});
            $('.phone_with_ddd').mask('(00) 00000-0000');
            
            //$("#selecionaTipo option:first").attr('selected','selected');//seleciona a primeira option do select            
            $("select#selecionaTipo").trigger("change");//simular que o usuário fez uma seleção e exibe a div oculta
        });

        $(function () {
            
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

    <script src="{{ asset('js/plugins/jquery.mask.min.js') }}"></script>
    
@endsection

@section('content')

    @page_component(['col' => 12])            
        
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component  

        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component
       
        @bodypage_component(['titulo' => $tituloPagina, 'descricao' => $descricaoPagina, 'rotaNome' => $rotaNome, 'page' => $page])
        
            @form_component(['action' => route($rotaNome.'.store'), 'method' => 'POST'])
                @include('site.admin.acl.'.$rotaNome.'._form')
                <hr>
                <button type="submit" class="btn btn-outline-success float-right btn-icon-split mt-2">
                    <span class="icon text-white bg-success">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text">Gravar</span>
                </button>                
            @endform_component
        @endbodypage_component

    @endpage_component
    
@endsection