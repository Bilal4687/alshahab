<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    {{-- <link rel="stylesheet"
        href="{{ url('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"> --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('public/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('public/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('public/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('public/plugins/summernote/summernote-bs4.min.css') }}">
    {{-- //Data tables  --}}
    <link rel="stylesheet" href="{{ url('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- jQuery -->
    <script src="{{ url('public/plugins/jquery/jquery.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ url('public/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!--Select2 CSS-->
    <script src="{{url('public/util.js')}}"></script>
    <style>
        .datable-img{
            height: 100px;
            width: auto;
        }

        .left-col {
            display: flex;
        }
        td.text-center {
            vertical-align: middle;
        }

        .left-col {
            float: left;
            width: 50%;
            padding-bottom: 10px
        }

        .right-col {
            float: left;
            width: 50%;
            padding-bottom: 10px
        }

        .dropdown-menu {
            width: 150px !important;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }


    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="overlay" class="overlay" style="display: none;">

    </div>
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <h5>Alshahab</h5>
           {{--  <img class="animation__shake" src="{{url('public/dist/img/AdmindLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60"> --}}
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
               <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>

                </li>
                  <p style="font-size: 20px; position: absolute; bottom: -2px; left: 53px;">@yield('heading')</p>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{route('Dashboard')}}" class="brand-link">
                <img src="{{ url('public/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Alshahab</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('Dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('Category') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Category
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('Slider') }}" class="nav-link">
                                <i class="nav-icon fas fa-image"></i>
                                <p>
                                    Slider
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('Attribute') }}" class="nav-link">
                                <i class="nav-icon fas fa-tag"></i>
                                <p>
                                    Attribute
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('Brand') }}" class="nav-link">
                                <i class="nav-icon fas fa-laugh"></i>
                                <p>
                                    Brand
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('Discount') }}" class="nav-link">
                                <i class="nav-icon fas fa-percent"></i>
                                <p>
                                    Discount
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('Product') }}" class="nav-link">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>
                                    Product
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Variation') }}" class="nav-link">
                                <i class="nav-icon fas fa-cubes"></i>
                                <p>
                                    Variation
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Blog') }}" class="nav-link">
                                <i class="nav-icon fas fa-cubes"></i>
                                <p>
                                    Blog
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('AdminLogout') }}" class="nav-link">
                                <i class="nav-icon fas fa-logout"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong><a href="https://adminlte.io">DualSyscoR&D</a>.</strong>
            All rights reserved.

        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <div class="modal" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="cropperModalLabel">Image Cropper</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="imageContainer"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="cropImage()">Crop Image</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    {{-- <script src="{{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script src="{{ url('public/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ url('public/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ url('public/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ url('public/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('public/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ url('public/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ url('public/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ url('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('public/dist/js/adminlte.js') }}"></script>
    <!--data tables links-->
    <!-- datatable -->
    <script src="{{ url('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('public/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('public/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('public/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- //sweet Alert -->
    <script src="{{ url('public/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Sweet Aleert Toast -->
    <script src="{{ url('public/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js">
    </body>
    </html>
