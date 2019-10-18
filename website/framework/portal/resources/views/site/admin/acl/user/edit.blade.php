@extends('layouts.site.admin.app')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('bootstrap-select/css/bootstrap-select.css') }}">    
@stop

@section('content')
    @page_component(['col' => 12])
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component          
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component

        @bodypage_component(['titulo' => $tituloPagina, 'descricao' => $descricaoPagina, 'rotaNome' => $rotaNome, 'page' => $page])
            @form_component(['action' => route($rotaNome.'.update', $registro->id), 'method' => 'PUT'])
            {{-- no caso de EDIT os tipos são armazenados na variavel abaixo para a selecao por JS --}}
            @php
                $arrayTipos = [];
                if($registro->tipo != "") {
                     $arrayTipos = explode(',', $registro->tipo);
                }                 
            @endphp
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

@section('js')
    @parent
    <script src="{{ asset('js/plugins/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('bootstrap-select/js/bootstrap-select.min.js') }}"></script>        

    <script>      
        $('#tipoFuncionario').css('display', 'none')        
        $('#tipoDocente').css('display', 'none')        
        $('#tipoAluno').css('display', 'none')

        //metodo que verifica se determinado valor está contido na variavel informada
        Array.prototype.contains = function(obj) {
            var i = this.length;
            while (i--) {
                if (this[i] === obj) {
                    return true;
                }
            }
            return false;
        }

        $(document).ready(function() {  
            
            $('[data-toggle="tooltip"]').tooltip();
            $('select#selecionaTipo').selectpicker();         
            
            //exibe ou nao as divs com os campos necessarios            
             $('#selecionaTipo').change(function() {                
                const tipo = $('#selecionaTipo').val();
                
                if(tipo.contains('F')) {
                    $('#tipoFuncionario').css('display', 'block')
                } else {
                    $('#tipoFuncionario').css('display', 'none')
                }
                if(tipo.contains('D')) {
                    $('#tipoDocente').css('display', 'block')
                } else {
                    $('#tipoDocente').css('display', 'none')
                }
                if(tipo.contains('A') || tipo.contains('EX')) {
                    $('#tipoAluno').css('display', 'block')
                } else {
                    $('#tipoAluno').css('display', 'none')
                }                
            });
            
            const tempArray = $('#selecionaTipo').val();                        
            if(tempArray.length > 0) {
                $('.selectpicker').selectpicker('val', tempArray);
            } else {
                $("#selecionaTipo option:first").attr('selected','selected');//seleciona a primeira option do select            
            }
            
            //Masks
            $('.cpf').mask('000.000.000-00', {reverse: true});
            $('.phone_with_ddd').mask('(00) 00000-0000');
            
            $("select#selecionaTipo").trigger("change");//simular que o usuário fez uma seleção e exibe a div oculta
        });        
    </script>
@stop