<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dashboard') }}</title>

     <!-- Jspreadsheet CE -->
    @stack('styles')

    <!-- Custom fonts for this template-->
    <link href="{{ asset('adminpage/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('adminpage/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('adminpage/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Leaflet styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Power BI CSS -->
    <style>
        #powerbi-container {
            width: 100%;
            height: 868px;
            border: 1px solid #ccc;
        }
    </style>

    <!-- Favicon -->
    <link href="{{ asset('adminpage/asset/img/gum.png') }}" rel="icon" type="image/png">

    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.partials.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('layouts.partials.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Yakin Akan Keluar?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih “Keluar” di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Batal') }}</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Keluar') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('adminpage/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminpage/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('adminpage/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('adminpage/js/sb-admin-2.min.js') }}"></script>

    <!-- Toastr scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('adminpage/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminpage/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('adminpage/js/demo/datatables-demo.js') }}"></script>

    <!-- Power BI scripts -->
    <script src="https://npmcdn.com/powerbi-client@2.22.0/dist/powerbi.min.js"></script>

    <!-- Chart Js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.4.0/dist/chartjs-plugin-annotation.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- Leaflet Js -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    @stack('scripts')

    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable-user').DataTable(); // aktifkan semua fitur default
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable-comp').DataTable(); // aktifkan semua fitur default
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable-aresta1').DataTable(); // aktifkan semua fitur default
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable-aresta2').DataTable(); // aktifkan semua fitur default
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable-curahhujan').DataTable(); // aktifkan semua fitur default
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable-sungai1').DataTable(); // aktifkan semua fitur default
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable-ffbint').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
        ]
    }); // aktifkan semua fitur default
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable-ffbeks').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
        ]
    }); // aktifkan semua fitur default
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable-ccpo').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
        ]
    }); // aktifkan semua fitur default
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable-kcpo').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
        ]
    }); // aktifkan semua fitur default
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable-cpk').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
        ]
    }); // aktifkan semua fitur default
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable-pupuk').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
        ]
    }); // aktifkan semua fitur default
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable-rawat').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
        ]
    }); // aktifkan semua fitur default
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable-payroll').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
                ]
            }); // aktifkan semua fitur default
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable-lho').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
                ]
            }); // aktifkan semua fitur default
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable-depre').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
                ]
            }); // aktifkan semua fitur default
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable-spartlho').DataTable({
                scrollX: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-nowrap' }
                ]
            }); // aktifkan semua fitur default
        });
    </script>
</body>
</html>