@if ($exibeMenu)
<div class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 sticky-top" role="navigation">
  <div class="container">
    <!-- Navbar-brand with hamburg menu -->
      <a class="navbar-brand h1 mb-0" href="{{ route('site') }}"><img src="{{ asset('img/site/logotipos/logofatec-white-2.png') }}" alt="logo-fatec" class="img-fluid" style="width: 90px; height: 30px;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    <!-- End Navbar-brand with hamburg menu -->

    <!-- Menu site -->
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ml-auto">
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="menuInstitucional" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Institucional</a>
          <ul class="dropdown-menu" aria-labelledby="menuInstitucional">
            <li class="dropdown-item"><a href="{{ route('ver.pagina', ['parametro' => 'historico']) }}">Histórico</a></li>
            <li class="dropdown-item"><a href="#">Corpo Administrativo</a></li>
            <li class="dropdown-item"><a href="#">Corpo Docente</a></li>
            <li class="dropdown-item"><a href="#">Congregação</a></li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-item"><a href="#">Diretoria de Serviços</a></li>
            <li class="dropdown-item"><a href="#">Diretoria Acadêmica</a></li>
            <li class="dropdown-divider"></li>                
            <li class="dropdown-item dropdown">
              <a class="dropdown-toggle" id="menuLabs-n1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Laboratórios</a>
                <ul class="dropdown-menu" aria-labelledby="menuLabs-n1">
                  <li class="dropdown-item"><a href="#">Processamento de Alimentos</a></li>
                  <li class="dropdown-item"><a href="#">Físico-Químico</a></li>
                  <li class="dropdown-item"><a href="#">Microbiologia</a></li>
                  <li class="dropdown-divider"></li>  
                  <li class="dropdown-item"><a href="#">Informática</a></li>                                   
                </ul>
            </li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-item"><a href="ceua.html">CEUA</a></li>          
          </ul>
        </li>
          
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-capitalize" id="menuCurso" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cursos</a>
          <ul class="dropdown-menu" aria-labelledby="menuCurso">   
            @foreach ($tipos as $tipo)
              @foreach ($cursos->getTipoCursoMenu($tipo->id) as $tipoMenu)             
                  <li class="dropdown-item dropdown">
                    <a class="dropdown-toggle" id="menuTipo-{{$tipo->id}}" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$tipoMenu->descricao}}</a>
                    <ul class="dropdown-menu" aria-labelledby="menuTipo-{{$tipo->id}}">
                      @foreach ($cursos->getModalidadesCursoMenu($tipo->id) as $modalidadeMenu) 
                        <li class="dropdown-item dropdown">
                          <a class="dropdown-toggle" id="menuModalidade-{{$modalidadeMenu->id}}-1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$modalidadeMenu->descricao}}</a>
                            <ul class="dropdown-menu" aria-labelledby="menuModalidade-{{$modalidadeMenu->id}}-1">
                              @foreach ($cursos->getCursosMenu($tipo->id, $modalidadeMenu->id) as $curso)
                                <li class="dropdown-item"><a href="{{route('ver.curso', ['id' => $curso->id])}}">{{$curso->nome}}</a></li>                                    
                              @endforeach                      
                            </ul>
                        </li>                            
                      @endforeach
                    </ul>
                  </li>
                @endforeach
              @endforeach
          </ul>
        </li>         
          
        <li class="nav-item"><a class="nav-link" href="{{ route('ver.pagina', ['parametro' => 'biblioteca']) }}">Biblioteca</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ route('todas.noticias') }}">Notícias</a></li>

        <li class="nav-item"><a class="nav-link" href="#">Eventos</a></li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="menuPublicacoes" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Publicações</a>                  
          <ul class="dropdown-menu" aria-labelledby="menuPublicacoes">
            <li class="dropdown-item"><a href="#">Revista Alimentus</a></li>
            <li class="dropdown-item"><a href="#">Tecnólogos em Foco</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="menuAlunos" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Alunos</a>
          <ul class="dropdown-menu" aria-labelledby="menuAlunos">
            <li class="dropdown-item"><a target="_blank" href="{{ url('https://siga.cps.sp.gov.br/aluno/login.aspx') }}">Acesso ao SIGA</a></li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-item"><a href="{{ route('ver.pagina', ['parametro' => 'estagio']) }}">Área de Estágios</a></li>
            
            <li class="dropdown-item dropdown d-none">
              <a class="dropdown-toggle" id="menuAlunos-n1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Área de Estágios</a>
              <ul class="dropdown-menu" aria-labelledby="menuAlunos-n1">
                <li class="dropdown-item"><a href="{{ route('ver.pagina', ['parametro' => 'estagio-na-fatec']) }}">Estágio na FATEC</a></li>
                <li class="dropdown-item"><a href="{{ route('ver.pagina', ['parametro' => 'estagio-em-empresas']) }}">Estágio em EMPRESAS</a></li>
              </ul>                                    
            </li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-item dropdown">                    
              <a class="dropdown-toggle" id="menuAlunos-n1-2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Downloads</a>
              <ul class="dropdown-menu" aria-labelledby="menuAlunos-n1-2">
                <li class="dropdown-item"><a href="#">Material de Aula</a></li>
                <li class="dropdown-item"><a href="#">Certificados de eventos</a></li>
              </ul>                                    
            </li>                                           
          </ul> 
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="menuVestibular-n1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Vestibular</a>
          <ul class="dropdown-menu" aria-labelledby="menuVestibular-n1">
            <li class="dropdown-item"><a href="{{ route('ver.pagina', ['parametro' => 'como-ingressar-via-vestibular']) }}">Como ingressar na Fatec</a></li>
            <li class="dropdown-item d-none"><a href="#">Documentos para matrícula</a></li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-item"><a target="_blank" href="{{ url('https://www.vestibularfatec.com.br/calendario/') }}">Calendário</a></li>                            
            <li class="dropdown-divider"></li>
            <li class="dropdown-item"><a target="_blank" href="{{ url('https://www.vestibularfatec.com.br/provas-gabaritos/') }}">Provas e Gabaritos</a></li>
            <li class="dropdown-item"><a target="_blank" href="{{ url('https://www.vestibularfatec.com.br/duvidas-frequentes/') }}">Dúvidas Frequentes</a></li>                            
            <li class="dropdown-divider"></li>
            <li class="dropdown-item"><a target="_blank" href="{{ url('http://www.portal.cps.sp.gov.br/publicacoes/guia-profissoes-tecnologicas.pdf') }}">Guia de Profissões</a></li>                            
          </ul>          
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin') }}" aria-haspopup="true" aria-expanded="false"><i class="fas fa-unlock-alt"></i></a>
        </li>

      </ul>        
    </div>
    <!-- End Menu site -->
  </div>
</div>
<!-- End Navbar -->
@endif