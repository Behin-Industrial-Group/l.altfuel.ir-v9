<!DOCTYPE html>
<?php 

use App\CustomClasses\UserInfo;
use App\CustomClasses\Access;
use App\CustomClasses\NumberOf;
use App\Models\IssuesCatagoryModel;
use App\Models\VideosCatagoriesModel;
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$issues_catagories = IssuescatagoryModel::get();
$videosCatagories = VideosCatagoriesModel::get();
?>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
            @yield('title')
        </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ Url('public/dist/css/bootstrap-theme.css') }}">
        <!-- Bootstrap rtl -->
        <link rel="stylesheet" href="{{ Url('public/dist/css/rtl.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ Url('public/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ Url('public/bower_components/Ionicons/css/ionicons.min.css') }}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ Url('public/bower_components/jvectormap/jquery-jvectormap.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ Url('public/dist/css/AdminLTE.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ Url('public/dist/css/skins/_all-skins.min.css') }}">
        <!-- babakhani datepicker -->
        <link rel="stylesheet" href="{{ Url('public/dist/css/persian-datepicker-0.4.5.min.css') }}" />
        <!-- daterange picker -->
        <link rel="stylesheet" href="{{ Url('public/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="{{ Url('public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
        <!-- iCheck for checkboxes an radio inputs -->
        <link rel="stylesheet" href="{{ Url('public/plugins/iCheck/all.css') }}">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="{{ Url('public/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="{{ Url('public/plugins/timepicker/bootstrap-timepicker.min.css') }}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ Url('public/bower_components/select2/dist/css/select2.min.css') }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css"/>
        <!-- jQuery 3 -->
    <script src="{{ Url('public/bower_components/jquery/dist/jquery.min.js') }}"></script>
       
        <style>
        body{ 
            background: #314755;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #26a0da, #314755);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #26a0da, #314755); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
          }
          tr{
            border-radius: 5px;
          }
          .dt-buttons{
              margin: 10px;
              text-align: left;
          }
          li a{
            color: white;
          }
        </style>
        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.header')
        </div>
        <div>
            @include('layouts.main-sidebar')
            <!-- Page Content -->
            <div class="content-wrapper">
                <section class="content">
                    @yield('content')
                </section>
            </div>
        </div>
        <footer class="main-footer text-left"> 
            <strong>Copyright &copy; 2020 <a href="http://altfuel.ir" target="_blank">ALTFUEL</a></strong>
        </footer>
        
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ Url('public/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ Url('public/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ Url('public/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ Url('public/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ Url('public/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ Url('public/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ Url('public/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ Url('public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ Url('public/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ Url('public/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ Url('public/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ Url('public/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ Url('public/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ Url('public/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ Url('public/dist/js/demo.js') }}"></script>
    <!-- babakhani datepicker -->
    <script src="{{ Url('public/dist/js/persian-date-0.1.8.min.js') }}"></script>
    <script src="{{ Url('public/dist/js/persian-datepicker-0.4.5.min.js') }}"></script>
    <!--ChartJs -->
    <script src="{{ Url('public/bower_components/chart.js/Chart.js') }}"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="{{ url('public/js/num2persian.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#table').DataTable({
                dom: 'Bfltip',
                buttons: [
                    { 'extend': 'excel', 'text': 'Excel', className: 'btn btn-info'},
                    { 'extend': 'pdf', 'PDF': 'Excel', className: 'btn btn-success'}
                ],
                'ajax': ''
            });
        });
    </script>
    <script>
        cama_seprate_price()
        function cama_seprate_price(){
            $('.price').each(function(){
                var v = $(this).val();
                var v_s = v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $($(this).parent().children()[1]).html(v_s)
            })
        }

        $('.price').on('keyup', function(){
            cama_seprate_price()
        })
        
    </script>
    @yield('script')
    </body>
    
</html>
