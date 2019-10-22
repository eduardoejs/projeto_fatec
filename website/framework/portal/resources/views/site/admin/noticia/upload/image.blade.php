@extends('layouts.site.admin.app')

@section('content')
    @page_component(['col' => 12])

        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component        
                
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component
       
        @bodypage_component(['titulo' => $tituloPagina, 'descricao' => $descricaoPagina, 'rotaNome' => $rotaNome, 'page' => $page])
            @form_component(['action' => route($rotaNome.'.store.upload.image'), 'method' => 'POST', 'enctype' => true])
                @include('site.admin.'.$rotaNome.'.upload._formImage')
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
                                <i class="fas fa-hdd"></i> {{ count($list->imagens) }} arquivo(s) - {{ Conversoes::bytesToHuman($list->imagens->sum('tamanho_arquivo')) }}
                            </CAPTION>
                            @foreach ($colunas as $key => $value)
                                <th scope="col">{{ $value }}</th>
                            @endforeach
                            <th scope="col">Ação</th>
                        </thead>
                        <tbody>
                            @forelse ($list->imagens as $arquivo)
                                <tr>
                                    <td>{{ $arquivo->id }}</td>
                                    <td><img src="{{ url('storage/imagens/noticias/'.$list->id.'/'. $arquivo->nome_arquivo) }}" alt="{{$arquivo->titulo}}" width=60 height=40></td>
                                    <td>{{ $arquivo->titulo }}</td>
                                    <td>{{ $arquivo->descricao }}</td>
                                    <td>{{ Carbon\Carbon::parse($arquivo->created_at)->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ Conversoes::bytesToHuman($arquivo->tamanho_arquivo) }}</td>                                
                                    <td>{{ File::extension($arquivo->nome_arquivo) }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-wrench"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton">                                                
                                                <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.destroy.image', ['id' => $noticia->id, 'imageId' => $arquivo->id]) }}"><i class="fa fa-trash"></i> Excluir</a>
                                                <a class="dropdown-item text-secondary" href=""><i class="fa fa-download"></i> Download</a>                                            
                                            </div>
                                        </div>                                                  
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan={{count($colunas)+1}}><div class="alert alert-primary text-center" role="alert"> Sem registros! </div></td>
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