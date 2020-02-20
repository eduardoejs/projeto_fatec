@extends('layouts.site.publico.app', ['exibeMenu' => true])

@section('conteudo')
    <div class="container">
        @if (isset($curso))
            <div class="mt-3 p-3 bg-light text-dark ">

                @if ($curso->tipoCurso->id == 2)
                    <h1 class="text-dark">Curso de Pós-Graduação em {{$curso->nome}}</h1>
                @else
                    <h1 class="text-dark">Curso Superior de Graduação em {{$curso->nome}}</h1>            
                @endif                
                
                <div class="mt-2">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tipo do curso:
                            <span class="badge badge-primary badge-pill">{{$curso->tipoCurso->descricao}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Modalidade:
                            <span class="badge badge-primary badge-pill">{{$curso->modalidade->descricao}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Duração do curso:
                            <span class="badge badge-primary badge-pill">{{$curso->duracao}} anos</span>
                        </li>
                        @if ($curso->modalidade->id == 2)

                        @else

                        @php                                    
                                    $arrayPeriodos = explode(',', $curso->periodo);
                                    $str = '';
                                    $periodos = '';
                                    foreach ($arrayPeriodos as $key => $value) {
                                        switch ($value) {
                                            case 'M':
                                                $str = 'Manhã';
                                                break;
                                            case 'T':
                                                $str = 'Tarde';
                                                break;
                                            case 'N':
                                                $str = 'Noite';
                                                break;
                                            default:
                                                $str = '-';
                                                break;
                                        }
                                        $periodos .= ' <span class="badge badge-primary badge-pill">'.$str.'</span>';
                                    }
                                @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Período do curso:
                                <div>{!!$periodos!!}</div>                                
                            </li>    
                        @endif
                        
                        @if ($curso->modalidade->id == 2)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Quantidade de vagas:
                                <span class="badge badge-primary badge-pill">{{$curso->qtde_vagas}} vagas</span>
                            </li>
                        @else
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Quantidade de vagas por período:
                                <span class="badge badge-primary badge-pill">{{$curso->qtde_vagas}} vagas</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="mt-2 p-3 bg-light text-primary">
                
                <h5>Coordenador do Curso: Prof. MSc. {{$curso->getCoordenador($curso->id)->first()->nome}}</h5>
                <h6><i class="fas fa-envelope"></i> {{$curso->email_coordenador}}</h6>
            </div>

            <div class="text-justify mt-3" id="corpo">
                {!! $curso->conteudo !!}
            </div>
        @endif
    </div>    
@endsection

@section('css')
    @parent 
    <style>
        #corpo p {
            text-indent: 2em;
        }   
    </style>
@endsection

@section('modais')
@endsection

@section('js')
    <script>
        $('.carousel').carousel({
            interval: 3000,
            pause: false
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $(function(){
            $('[data-toggle="popover"]').popover()
        }); 
    </script>    
@endsection