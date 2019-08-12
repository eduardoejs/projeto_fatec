<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <!-- Navbar-brand with hamburg menu -->
        <a href="#" class="navbar-brand h1 mb-0"><img src="img/site/logotipos/logofatec-white-2.png" alt="logo-fatec" class="img-fluid" style="width: 90px; height: 30px;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSite">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- End Navbar-brand with hamburg menu -->

        <!-- Menu site -->
        <div id="navbarSite" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Institucional
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Histórico</a></li>
                        <li><a class="dropdown-item" href="#">Corpo Administrativo</a></li>
                        <li><a class="dropdown-item" href="#">Corpo Docente</a></li>
                        <li><a class="dropdown-item" href="#">Congregação</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Diretoria de Serviços</a></li>
                        <li><a class="dropdown-item" href="#">Secretaria Acadêmica</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Laboratórios</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Processamento de Alimentos</a></li>
                                <li><a class="dropdown-item" href="#">Físico-Químico</a></li>
                                <li><a class="dropdown-item" href="#">Microbiologia</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Informática</a></li>
                            </ul>                                    
                        </li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="ceua.html">CEUA</a></li>
                    </ul>                        
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cursos
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Graduação (Presencial)</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="curso_alimentos.html">Tecnologia em Alimentos</a></li>
                            </ul>                                    
                        </li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Graduação à distância (EaD)</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Gestão Empresarial</a></li>
                            </ul>                                    
                        </li>
                    </ul>                        
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#">Biblioteca</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Notícias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Eventos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Publicações
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Revista Alimentus</a></li>
                        <li><a class="dropdown-item" href="#">Tecnólogos em Foco</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Alunos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Acesso ao SIGA</a></li>                                                        
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Área de Estágios</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Estágio na FATEC</a></li>
                                <li><a class="dropdown-item" href="#">Estágio em EMPRESAS</a></li>
                            </ul>                                    
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Downloads</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Material de Aula</a></li>
                                <li><a class="dropdown-item" href="#">Certificados de eventos</a></li>
                            </ul>                                    
                        </li>                            
                    </ul>                          
                </li>                          
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Vestibular
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Como ingressar na Fatec</a></li>
                        <li><a class="dropdown-item" href="#">Documentos para matrícula</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">calendário</a></li>                            
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Provas e Gabaritos</a></li>
                        <li><a class="dropdown-item" href="#">Dúvidas Frequentes</a></li>                            
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Guia de Profissões</a></li>                            
                    </ul>
                </li>  
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('admin') }}" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-unlock-alt"></i>
                    </a>                        
                </li>                      
            </ul>
        </div>
        <!-- End Menu site -->
    </div>
</nav>
<!-- End Navbar -->