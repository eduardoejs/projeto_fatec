<div class="table-responsive" style="min-height: 21rem">
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                @foreach ($colunas as $key => $value)
                    <th scope="col">{{ $value }}</th>
                @endforeach
                <th scope="col">Ação</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($list as $key => $value)
                <tr>
                    @foreach ($colunas as $nomeColuna => $valorColuna)
                        @if ($nomeColuna == 'id')
                            <th scope='row'>@php echo $value->{$nomeColuna} @endphp</th>
                        @else                        
                            
                            @if ($nomeColuna == 'status')                            
                                @if ($value->{$nomeColuna} == 'SIM')
                                    <td><span class="badge badge-pill badge-success">@php echo $value->{$nomeColuna} @endphp</span></td>    
                                @else
                                    <td><span class="badge badge-pill badge-danger">@php echo $value->{$nomeColuna} @endphp</span></td>    
                                @endif                                
                            @else
                                @if ($nomeColuna == 'user')
                                <td>@php echo $value->{$nomeColuna}->nome_abr @endphp</td>
                                @else
                                    <td>@php echo $value->{$nomeColuna} @endphp</td>        
                                @endif 
                            @endif                            
                        @endif                       

                    @endforeach
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-wrench"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton">
                                @if (isset($page) && $page == 'Notícias' || $page == 'Páginas')
                                    <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.show',$value->id) }}"><i class="fa fa-info-circle"></i> Detalhes</a>
                                    {{-- @can('updateNews', $value) --}}
                                        <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.edit', $value->id) }}"><i class="fa fa-edit"></i> Editar</a>    
                                    {{-- @endcan
                                    @can('deleteNews', $value)                                 --}}
                                        <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.show',[$value->id, 'delete=true']) }}"><i class="fa fa-trash"></i> Excluir</a>                                    
                                    {{-- @endcan                                
                                    @can('uploads', $value)  --}}
                                        @if ($page == 'Páginas')
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.uploads',['news' => $value->id, 'typeUpload' => 'file']) }}"><i class="fa fa-file"></i> Anexar Arquivos</a>    
                                        @else
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.uploads',['news' => $value->id, 'typeUpload' => 'image']) }}"><i class="fa fa-images"></i> Anexar Imagens</a>
                                            <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.uploads',['news' => $value->id, 'typeUpload' => 'file']) }}"><i class="fa fa-file"></i> Anexar Arquivos</a>
                                        @endif                                        
                                    {{-- @endcan --}}
                                @else
                                    <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.show',$value->id) }}"><i class="fa fa-info-circle"></i> Detalhes</a>
                                    <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.edit', $value->id) }}"><i class="fa fa-edit"></i> Editar</a>
                                    <a class="dropdown-item text-secondary" href="{{ route($rotaNome.'.show',[$value->id, 'delete=true']) }}"><i class="fa fa-trash"></i> Excluir</a>                                        
                                @endif
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
    