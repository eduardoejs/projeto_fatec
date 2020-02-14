<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
          <div class="sidebar-brand-icon rotate-n-15">
            {{--<i class="fas fa-tachometer-alt"></i>--}}
          </div>
          <div class="sidebar-brand-text mx-3">{{config('app.name')}}</div>
        </a>
  
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
  
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
          <a class="nav-link" href="{{ route('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </li>
        
        @if(auth()->user()->can('read-perfil') || auth()->user()->can('read-permission') || auth()->user()->can('read-user')) 
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->        
        <div class="sidebar-heading">
          Segurança
        </div>
        @php
            //sem clicar
            $collapsed = 'collapsed';
            $active = '';
            $show = '';

            //expandiu o menu
            if(Request::segment(1) == 'admin' && Request::segment(2) == 'acl') {
              $collapsed = '';
              $show = 'show';
              $active = 'active';
            }
        @endphp

        <!-- Nav Item - Charts -->
        <!-- Nav Item - Pages Collapse Menu -->        
        <li class="nav-item {{ $active }}">
          <a class="nav-link {{ $collapsed }}" href="#" data-toggle="collapse" data-target="#collapseAcl" aria-expanded="true" aria-controls="collapseAcl">
            <i class="fas fa-fw fa-user-lock"></i>
            <span>ACL e Usuários</span>
          </a>
          <div id="collapseAcl" class="collapse {{ $show }}" aria-labelledby="headingAcl" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Menu de Opções:</h6>
              @can('read-perfil')
                <a class="collapse-item {{ Request::segment(3) == 'perfil' ? 'active' : '' }}" href="{{ route('perfil.index') }}"> <i class="fas fa-id-card"></i> Perfil de Usuário</a>  
              @endcan              
              @can('read-permission')
                <a class="collapse-item {{ Request::segment(3) == 'permissao' ? 'active' : '' }}" href="{{ route('permissao.index') }}"><i class="fas fa-user-lock"></i> Permissões</a>  
              @endcan              
              @can('read-user')
                <a class="collapse-item {{ Request::segment(3) == 'user' ? 'active' : '' }}" href="{{ route('user.index') }}"> <i class="fas fa-user-friends"></i> Usuários</a>                
              @endcan              
            </div>
          </div>
        </li>
        @endif
               
        @if(auth()->user()->can('read-noticia') || auth()->user()->can('read-pagina') || auth()->user()->can('read-curso')) 
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->        
        <div class="sidebar-heading">
          Conteúdo do Portal
        </div>
        @php
            //sem clicar
            $collapsed = 'collapsed';
            $active = '';
            $show = '';

            //expandiu o menu
            if(Request::segment(1) == 'admin' && (Request::segment(2) == 'noticia' || Request::segment(2) == 'curso' )) {
              $collapsed = '';
              $show = 'show';
              $active = 'active';
            }
        @endphp

        <!-- Nav Item - Charts -->
        <!-- Nav Item - Pages Collapse Menu -->        
        <li class="nav-item {{ $active }}">
          <a class="nav-link {{ $collapsed }}" href="#" data-toggle="collapse" data-target="#collapseContentPortal" aria-expanded="true" aria-controls="collapseContentPortal">
            <i class="fas fa-fw fa-user-lock"></i>
            <span>Gerenciamento</span>
          </a>
          <div id="collapseContentPortal" class="collapse {{ $show }}" aria-labelledby="headingAcl" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Menu de Opções:</h6>
              @can('read-curso')
                <a class="collapse-item {{ Request::segment(2) == 'curso' ? 'active' : '' }}" href="{{ route('curso.index') }}"><i class="fas fa-graduation-cap"></i> Cursos</a>  
              @endcan
              @can('read-noticia')
                <a class="collapse-item {{ Request::segment(2) == 'noticia' ? 'active' : '' }}" href="{{ route('noticia.index') }}"><i class="fas fa-book-open"></i> Notícias</a>  
              @endcan              
              @can('read-pagina')
                <a class="collapse-item {{ Request::segment(2) == 'pagina' ? 'active' : '' }}" href="#"><i class="fas fa-chalkboard"></i> Páginas</a>  
              @endcan              
            </div>
          </div>
        </li>
        @endif
  
        <!-- Divider -->
        <hr class="sidebar-divider">
  
        <!-- Heading -->
        <div class="sidebar-heading">
          Interface
        </div>
  
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Custom Components:</h6>
              <a class="collapse-item" href="buttons.html">Buttons</a>
              <a class="collapse-item" href="cards.html">Cards</a>
            </div>
          </div>
        </li>
  
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
          </a>
          <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Custom Utilities:</h6>
              <a class="collapse-item" href="utilities-color.html">Colors</a>
              <a class="collapse-item" href="utilities-border.html">Borders</a>
              <a class="collapse-item" href="utilities-animation.html">Animations</a>
              <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
          </div>
        </li>
  
        <!-- Divider -->
        <hr class="sidebar-divider">
  
        <!-- Heading -->
        <div class="sidebar-heading">
          Addons
        </div>
  
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
          </a>
          <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Login Screens:</h6>
              <a class="collapse-item" href="login.html">Login</a>
              <a class="collapse-item" href="register.html">Register</a>
              <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
              <div class="collapse-divider"></div>
              <h6 class="collapse-header">Other Pages:</h6>
              <a class="collapse-item" href="404.html">404 Page</a>
              <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
          </div>
        </li>
  
        <!-- Nav Item - Charts -->
        <li class="nav-item">
          <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
        </li>
  
        <!-- Nav Item - Tables -->
        <li class="nav-item">
          <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
        </li>
  
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
  
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
  
      </ul>
      <!-- End of Sidebar -->