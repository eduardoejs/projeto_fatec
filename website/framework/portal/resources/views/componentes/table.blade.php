<div class="table-responsive">
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
                            <td>@php echo $value->{$nomeColuna} @endphp</td>
                        @endif
                    @endforeach
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-wrench"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route($rotaNome.'.show',$value->id) }}"><i class="fa fa-eye"></i> Detalhes</a>
                                <a class="dropdown-item" href="{{ route($rotaNome.'.edit', $value->id) }}"><i class="fa fa-edit"></i> Editar</a>
                                <a class="dropdown-item" href="{{ route($rotaNome.'.show',[$value->id, 'delete=true']) }}"><i class="fa fa-trash-o"></i> Excluir</a>                                    
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
    