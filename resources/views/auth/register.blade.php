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
    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('theme/dist/fonts/ionicons/ionicons.min.css') !!}">
    <!-- Tempusdominus Bootstrap 4 -->

    <link rel="stylesheet" href="{!! asset('theme/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}">
    <!-- iCheck -->
    
    <link rel="stylesheet" href="{!! asset('theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
    <!-- JQVMap -->
    
    <!-- <link rel="stylesheet" href="{!! asset('theme/plugins/jqvmap/jqvmap.min.css') !!}"> -->

    <!-- DataTables -->
    
    <link rel="stylesheet" href="{!! asset('theme/plugins/datatables/jquery.dataTables.min.css') !!}">
    
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


</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper login_section">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{URL::asset('/theme/dist/img/Spinner-2.gif')}}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <div class="login_box">
            <div class="login_left">
                <img src="theme/dist/images/logo_white.png">
            </div>
            <div class="login_form_box">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <h1 class="text-center">Login</h1>
                    
                    <div class="form-group">
                        <label for="email">Name :</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pwd">Confirm Password:</label>
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
            

                    <button type="submit" class="btn login_btn btn-block">Submit</button>

                    <div class="d-flex align-items-center my-2">
                        <hr class="flex-grow-1 bg-dark-4">
                        <span class="mx-2 text-2 text-muted">Or with Social Profile</span>
                        <hr class="flex-grow-1 bg-dark-4">
                    </div>
                    <div class="mb-2">
                        <ul class="social_icons">
                            <li>
                                <a href="#" data-bs-toggle="tooltip" data-bs-original-title="Log In with Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-bs-toggle="tooltip" data-bs-original-title="Log In with Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-bs-toggle="tooltip" data-bs-original-title="Log In with Google">
                                    <i class="fab fa-google"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-bs-toggle="tooltip" data-bs-original-title="Log In with Linkedin">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <p class="text-2 text-center mb-0">Already have an account?  <a class="login_form_btn" href="{{ route('login') }}">Sign in</a></p>

                </form>

            </div>
        </div>
    </div>
    </div>
    </div>

    </div>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{!! asset('theme/plugins/jquery/jquery.min.js') !!}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{!! asset('theme/plugins/jquery-ui/jquery-ui.min.js') !!}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{!! asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <!-- ChartJS -->
    <script src="{!! asset('theme/plugins/chart.js/Chart.min.js') !!}"></script>
    <!-- Sparkline -->
    <script src="{!! asset('theme/plugins/sparklines/sparkline.js') !!}"></script>
    <!-- JQVMap -->
    <!-- <script src="{!! asset('theme/plugins/jqvmap/jquery.vmap.min.js') !!}"></script>
<script src="{!! asset('theme/plugins/jqvmap/maps/jquery.vmap.usa.js') !!}"></script> -->
    <!-- jQuery Knob Chart -->
    <script src="{!! asset('theme/plugins/jquery-knob/jquery.knob.min.js') !!}"></script>
    <!-- daterangepicker -->
    <script src="{!! asset('theme/plugins/moment/moment.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/daterangepicker/daterangepicker.js') !!}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{!! asset('theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
    <!-- Summernote -->
    <script src="{!! asset('theme/plugins/summernote/summernote-bs4.min.js') !!}"></script>
    <!-- overlayScrollbars -->
    <script src="{!! asset('theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}"></script>


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

    <!-- AdminLTE App -->
    <script src="{!! asset('theme/dist/js/adminlte.js') !!}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{!! asset('theme/dist/js/demo.js') !!}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="{!! asset('theme/dist/js/pages/dashboard.js') !!}"></script> -->

    <!-- Data Table js -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example2').DataTable({
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                order: [
                    [1, 'asc']
                ],
                "scrollX": true
            });
        });
    </script>




</body>

</html>