<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>{{config('app.name')}} - Admin</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('sbadmin/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('sbadmin/css/sb-admin-2.min.css')}}" rel="stylesheet">

  @hasSection ('css')
    @yield('css')
  @endif

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    @include('includes.layout.site.admin.sidebar')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">        
        @include('includes.layout.site.admin.topbar')
        <!-- Begin Page Content -->
        <div class="container-fluid">
            @hasSection ('content')                
              @yield('content')                
            @endif            
        </div>  
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      @include('includes.layout.site.admin.footer')
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  @hasSection ('modal')
    @yield('modal')
  @endif

  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('sbadmin/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('sbadmin/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('sbadmin/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('sbadmin/js/sb-admin-2.min.js')}}"></script>

  <!-- Page level plugins -->
  {{-- <script src="{{asset('sbadmin/chart.js/Chart.min.js')}}"></script> --}}

  <!-- Page level custom scripts -->
  {{--<script src="{{asset('sbadmin/js/demo/chart-area-demo.js')}}"></script>
  <script src="{{asset('sbadmin/js/demo/chart-pie-demo.js')}}"></script>--}}
  
  @hasSection ('js')
    @yield('js')
  @endif

</body>

</html>