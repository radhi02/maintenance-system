<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', ':: Maintenance Managment ::') }}</title>
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!! asset('theme/plugins/fontawesome-free/css/all.min.css') !!}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{!! asset('theme/plugins/myjs/fullcalendar.css') !!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('theme/dist/fonts/ionicons/ionicons.min.css') !!}">
    <!-- Tempusdominus Bootstrap 4 -->

    <link rel="stylesheet" href="{!! asset('theme/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}">
    <!-- iCheck -->
    
    <link rel="stylesheet" href="{!! asset('theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
    <!-- JQVMap -->
    
    <!-- <link rel="stylesheet" href="{!! asset('theme/plugins/jqvmap/jqvmap.min.css') !!}"> -->

    <!-- DataTables -->
    
    <!-- Arrows are designed here in jquery.dataTables.min.css -->
    {{-- <link rel="stylesheet" href="{!! asset('theme/plugins/datatables/jquery.dataTables.min.css') !!}"> --}}
    
    <link rel="stylesheet" href="{!! asset('theme/plugins/datatables/select.dataTables.min.css') !!}">
    
    <link rel="stylesheet" href="{!! asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}">
    
    <link rel="stylesheet" href="{!! asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}">
    
    <link rel="stylesheet" href="{!! asset('theme/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') !!}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{!! asset('theme/dist/css/adminlte.min.css') !!}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{!! asset('theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') !!}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{!! asset('theme/plugins/daterangepicker/daterangepicker.css') !!}">
    <!-- summernote -->
    <link rel="stylesheet" href="{!! asset('theme/plugins/summernote/summernote-bs4.min.css') !!}">
    <!-- custom css added here -->
    <link rel="stylesheet" href="{!! asset('theme/dist/css/main.css') !!}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" />

    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{!! asset('theme/plugins/jquery/jquery.min.js') !!}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    // $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{!! asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{!! asset('theme/plugins/jquery-ui/jquery-ui.min.js') !!}"></script>
    <!-- ChartJS -->
    <script src="{!! asset('theme/plugins/chart.js/Chart.min.js') !!}"></script>
    <!-- Sparkline -->
    <script src="{!! asset('theme/plugins/sparklines/sparkline.js') !!}"></script>
    <!-- JQVMap -->
    <!-- <script src="{!! asset('theme/plugins/jqvmap/jquery.vmap.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/jqvmap/maps/jquery.vmap.usa.js') !!}"></script> -->
    <!-- jQuery Knob Chart -->
    <script src="{!! asset('theme/plugins/jquery-knob/jquery.knob.min.js') !!}"></script>
    <!-- AdminLTE App -->
    <script src="{!! asset('theme/dist/js/adminlte.js') !!}"></script>
    <!-- daterangepicker -->
    <script src="{!! asset('theme/plugins/moment/moment.min.js') !!}"></script>

    <script src="{!! asset('theme/plugins/daterangepicker/daterangepicker.js') !!}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{!! asset('theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
    <!-- Summernote -->
    <script src="{!! asset('theme/plugins/summernote/summernote-bs4.min.js') !!}"></script>
    <!-- overlayScrollbars -->
    <script src="{!! asset('theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}"></script>

    {{-- <!-- AdminLTE App -->
    <script src="{!! asset('theme/dist/js/adminlte.js') !!}"></script> --}}

    <!-- DataTables  & Plugins -->
    <script src="{!! asset('theme/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datatables/dataTables.select.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datatables-buttons/js/dataTables.buttons.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/jszip/jszip.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/pdfmake/pdfmake.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/pdfmake/vfs_fonts.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datatables-buttons/js/buttons.html5.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datatables-buttons/js/buttons.print.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datatables-buttons/js/buttons.colVis.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/validation/jquery.validate.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/validation/additional-methods.js') !!}"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="{!! asset('theme/plugins/myjs/fullcalendar.js') !!}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="{!! asset('theme/dist/js/pages/dashboard.js') !!}"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{URL::asset('/theme/dist/img/Spinner-2.gif')}}" alt="AdminLTELogo" height="60" width="60">
    </div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Maintenance Managment') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <!-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div> -->
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Navbar -->
      @include('theme.header')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
      @include('theme.sidebar')
    <!-- /. Main Sidebar Container -->

    <!-- Content Wrapper. Contains page content -->
    @yield('content')
    <!-- /.content-wrapper -->
    
    <footer class="main-footer">
      <strong>Copyright ©  2022. Designed by :   <a href="https://thesanfinity.com/" target="_blank">Sanfinity Creative Solution</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.1.0
      </div>
    </footer>


  </div>


<!-- Data Table js -->
<script type="text/javascript">
  $(document).ready(function() {
     $('#tblcompany,#tblvendor,#tbldepartment,#tblequipement,#tblrole,#tbltask,#tbluser,#tblplan,#tblassignplan,#tblcomplatedplan').DataTable();
     $("#tblpermission").dataTable({
        "bPaginate": false
    });
} );
</script>
<!-- AdminLTE for demo purposes -->
<script src="{!! asset('theme/dist/js/demo.js') !!}"></script>




</body>

</html>
