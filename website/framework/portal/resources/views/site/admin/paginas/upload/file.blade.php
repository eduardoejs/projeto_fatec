@extends('layouts.site.admin.app')

@section('content')
    @page_component(['col' => 12])

        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component        
                
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component
       
        @bodypage_component(['titulo' => $pageTitle, 'descricao' => $pageDescription, 'rotaNome' => $routeName, 'page' => $page])
            @form_component(['action' => route($routeName.'.uploads.store', ['typeUpload' => 'file']), 'method' => 'POST', 'enctype' => true])
                @include('site.admin.'.$pathBlade.'.upload._formFile')
                <button type="submit" class="btn btn-outline-success float-right btn-icon-split">
                    <span class="icon text-white bg-success">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text">Gravar</span>
                </button>                
            @endform_component                        
        @endbodypage_component 
        <div class="my-3">
            @bodypage_component(['titulo' => 'Arquivos enviados', 'descricao' => '', 'rotaNome' => '', 'page' => ''])
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>                            
                            <CAPTION ALIGN="bottom">
                                <i class="fas fa-hdd"></i> {{ count($list->arquivos) }} arquivo(s) - {{ Conversoes::bytesToHuman($list->arquivos->sum('tamanho_arquivo')) }}
                            </CAPTION>
                            @foreach ($columnsTable as $key => $value)
                                <th scope="col" class="">{{ $value }}</th>
                            @endforeach
                            <th scope="col">Ação</th>
                        </thead>
                        <tbody>
                            @forelse ($list->arquivos()->orderBy('arquivo_pagina.created_at', 'ASC')->get() as $arquivo)
                                <tr>
                                    <td class="align-middle">{{ $arquivo->id }}</td>
                                    <td class="align-middle">{{ $arquivo->titulo }}</td>
                                    <td class="align-middle">{{ Carbon\Carbon::parse($arquivo->created_at)->format('d/m/Y H:i:s') }}</td>
                                    <td class="align-middle">{{ Conversoes::bytesToHuman($arquivo->tamanho_arquivo) }}</td>                                
                                    <td class="align-middle">{{ File::extension($arquivo->nome_arquivo) }}</td>
                                    
                                    <td class="align-middle">
                                        <div class="dropdown align-middle">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-wrench"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton"> 
                                                @form_component(['action' => route($routeName.'.delete.file', ['pagina' => $pagina->id, 'fileId' => $arquivo->id, 'typeDownload' => 'file']), 'method' => 'DELETE'])
                                                    <button type="submit" class="dropdown-item text-secondary"><i class="fa fa-trash"></i> Excluir</button>
                                                @endform_component
                                                <a class="dropdown-item text-secondary" href="{{ route($routeName.'.download.file', ['pagina' => $pagina->id, 'fileId' => $arquivo->id, 'typeDownload' => 'file']) }}"><i class="fa fa-download"></i> Download</a>                                            
                                            </div>
                                        </div>                                                  
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan={{count($columnsTable)+1}}><div class="alert alert-primary text-center" role="alert"> Sem registros! </div></td>
                                </tr>
                            @endforelse                        
                        </tbody>
                    
                    </table>
                </div>            
            @endbodypage_component
        </div>       
    @endpage_component    
@endsection

@section('js')
    @parent
    <script>
        $(function() {
            // We can attach the `fileselect` event to all file inputs on the page
            $(document).on('change', ':file', function() {                
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            // We can watch for our custom `fileselect` event like this
            $(document).ready( function() {
                $(':file').on('fileselect', function(event, numFiles, label) {
                    var input = $(this).parents('.input-group').find(':text'),
                        log = numFiles > 1 ? numFiles + ' arquivos selecionados' : label;
                    if( input.length ) {
                        input.val(log);
                    } else {
                        if( log ) alert(log);
                    }
                });
            });
        });       
    </script> 
@stop