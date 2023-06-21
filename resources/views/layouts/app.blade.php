
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/dashboard/plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('public/dashboard/dist/css/adminlte.min.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ url('public/dashboard/plugins/datepicker/datepicker3.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('public/dashboard/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ url('public/dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{ url('public/dashboard/dist/css/bootstrap-rtl.min.css') }}">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{ url('public/dashboard/dist/css/custom-style.css') }}">
    <link rel="stylesheet" href="{{ url('public/dashboard/dist/css/custom.css') }}">

    {{-- <link rel="stylesheet" href="{{ url('public/dashboard/dist/css/custom.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ url('public/dashboard/plugins/datatables/dataTables.bootstrap4.css') }}" />
    <link rel="stylesheet" href="{{ url('public/dashboard/dist/css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/leaflet/leaflet.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ Url('public/dist/css/persian-datepicker-0.4.5.min.css') }}" />
    <link rel="stylesheet" href="{{ Url('public/green-player/css/green-audio-player.css') }}" />
    <link rel="stylesheet" href="{{ Url('public/green-player/css/green-audio-player.min.css') }}" />
    @yield('style')

    <script src="{{ url('public/dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('public/dashboard/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ url('public/dashboard/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ url('public/js/ajax.js') }}"></script>
    <script src="{{ url('public/js/dataTable.js') }}"></script>
    <script src="{{ url('public/js/dropzone.js') }}"></script>
    
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
    
        @include('layouts.header')
    
        @include('layouts.main-sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>



        <footer class="main-footer">
            {{-- <strong> &copy; 2018 <a href="http://github.com/hesammousavi/">حسام موسوی</a>.</strong> --}}
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
        $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{ url('public/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Morris.js charts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="{{ url('public/dashboard/plugins/morris/morris.min.js') }}"></script>
        <!-- Sparkline -->
        <script src="{{ url('public/dashboard/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        <!-- jvectormap -->
        <script src="{{ url('public/dashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ url('public/dashboard/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ url('public/dashboard/plugins/knob/jquery.knob.js') }}"></script>
        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
        <script src="{{ url('public/dashboard/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- datepicker -->
        <script src="{{ url('public/dashboard/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{ url('public/dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
        <!-- Slimscroll -->
        <script src="{{ url('public/dashboard/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ url('public/dashboard/plugins/fastclick/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ url('public/dashboard/dist/js/adminlte.js') }}"></script>

        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
        <script src="{{ Url('public/dist/js/persian-date-0.1.8.min.js') }}"></script>
        <script src="{{ Url('public/dist/js/persian-datepicker-0.4.5.min.js') }}"></script>

        <script src="{{ Url('public/green-player/js/green-audio-player.js') }}"></script>
        <script src="{{ Url('public/green-player/js/green-audio-player.min.js') }}"></script>

        
        
        <script>

            // $(document).ready(function() {
            //     $('#table').DataTable({
            //         dom: 'Bfltip',
            //         buttons: [{
            //             'extend': 'excel',
            //             'text': 'Excel',
            //             className: 'btn btn-info'
            //         }],
            //         'ajax': ''
            //     });
            //     $('table').attr('style', 'font-weight:bold; font-size: 12px')

            //     initial_view();
            //     hide_loading();
            // });

            function initial_view(){
                $('.select2').select2();
                $(".persian-date").persianDatepicker({
                    viewMode: 'year',
                    format: 'YYYY-MM-DD',
                    initialValueType: 'persian'
                });
            }

            

            

            

        </script>

        <script>
            $('form').keypress(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                }
            });
            

        </script>
        <script src="{{ url('public/js/loader.js') }}"></script>
        <script src="{{ url('public/js/clearcach.js') }}"></script>
        <script src="{{ url('public/js/scripts.js') }}"></script>

        @yield('script')
    </div>



</body>

</html>
