<!-- Noticias -->
<div class="container">
                
    <div class="row justify-content-between mt-5">
        <div class="col-sm-6 text-secondary">
            <h4 class="display-4"><i class="far fa-newspaper"></i> Notícias</h4>
            <p><em>Fique por dentro das últimas notícias que a Fatec fez parte.</em></p>
        </div>
        <div class="col-sm-6 text-right align-self-center">
                <a href="#" class="btn btn-outline-info">Veja todas as notícias <i class="far fa-plus-square"></i></a>
        </div>
    </div>        
    <div class="row noticias justify-content-sm-center mt-2 mb-5">
        <div class="card-deck">
            @foreach ($noticias as $noticia)
                <div class="card">
                    @if (isset($noticia->imagens()->where('ordem', 1)->first()->nome_arquivo))
                        <img src="{{ url('storage/imagens/noticias/'.$noticia->id.'/thumbnail/medium/'. $noticia->imagens()->where('ordem',1)->first()->nome_arquivo) }}" alt="news" class="card-img-top img-fluid img-thumbnail">
                    @else
                        <img src="{{ url('storage/imagens/default/no_image.jpeg') }}" alt="news" class="card-img-top img-fluid img-thumbnail">        
                    @endif
                    
                    <div class="card-body">
                        <h4 class="card-title text-center"><strong>{{ $noticia->titulo }}</strong></h4>
                        <p class="card-text text-justify">{!! $noticia->conteudo_resumido !!}</p>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex flex-row">
                            <div class="col d-flex align-items-center justify-content-center">
                                <small class="d-block text-muted"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="col">
                                <a href="{{ route('ler.noticia', ['id' => $noticia->id]) }}" class="card-link btn btn-outline-info d-block">Leia mais <i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{--<div class="card">
                <img src="img/cards/noticias/card11.jpg" alt="news" class="card-img-top img-fluid img-thumbnail">        
                <div class="card-body">
                    <h4 class="card-title text-center">PROCESSO DE SELEÇÃO PARA O PROGRAMA DE BOLSAS IBERO-AMERICANAS</h4>
                    <p class="card-text text-justify">Assessoria de Relações Internacionais (ARInter) – Assessoria Técnica da Superintendência convida os interessados a se inscrever no Processo Seletivo para concessão de 10 (dez) bolsas do Programa Santander Bolsas Ibero-Americanas ...</p>
                </div>
                <div class="card-footer">
                    <div class="row d-flex flex-row">
                        <div class="col d-flex align-items-center justify-content-center">
                            <small class="d-block text-muted"><i class="far fa-calendar-alt"></i> 05/06/2018</small>
                        </div>
                        <div class="col">
                            <a href="#" class="card-link btn btn-outline-info d-block">Leia mais <i class="fas fa-plus"></i></a>                                   
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <img src="img/cards/noticias/card22.jpg" alt="news" class="card-img-top img-fluid img-thumbnail">        
                <div class="card-body">
                    <h4 class="card-title text-center">Trabalhos de Docentes são Premiados em Simpósio da UNESP de Araraquara</h4>
                    <p class="card-text">Docentes da FATEC/MARÍLIA ganham 2 prêmios “Menção Honrosa” entre os três melhores trabalhos apresentados no 2° SIMPÓSIO DA PÓS-GRADUAÇÃO EM ALIMENTOS E NUTRIÇÃO da FACULDADE DE CIÊNCIAS FARMACÊUTICAS- UNESP- Araraquara/SP ...</p>
                </div>
                <div class="card-footer">
                    <div class="row d-flex flex-row">
                        <div class="col d-flex align-items-center justify-content-center">
                            <small class="d-block text-muted"><i class="far fa-calendar-alt"></i> 05/06/2018</small>
                        </div>
                        <div class="col">
                            <a href="#" class="card-link btn btn-outline-info d-block">Leia mais <i class="fas fa-plus"></i></a>                                   
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <img src="img/cards/noticias/card33.jpg" alt="news" class="card-img-top img-fluid img-thumbnail">        
                <div class="card-body">
                    <h4 class="card-title text-center">Trabalhos de Docentes são Premiados </h4>
                    <p class="card-text">A Fatec Marília oferece aos seus alunos aprimoramento e capacitação com palestras extracurriculares no dia 22/08/2018.</p>
                </div>
                <div class="card-footer">
                    <div class="row d-flex flex-row">
                        <div class="col d-flex align-items-center justify-content-center">
                            <small class="d-block text-muted"><i class="far fa-calendar-alt"></i> 05/06/2018</small>
                        </div>
                        <div class="col">
                            <a href="#" class="card-link btn btn-outline-info d-block">Leia mais <i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>--}}
        </div>
    </div>
</div>
<!-- End Noticias -->