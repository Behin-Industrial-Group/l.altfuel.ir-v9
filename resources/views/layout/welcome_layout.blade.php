<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
      @yield('title')
  </title>
  <style>
      @yield('CustomeCss')
  </style>
  <!-- Tell the browser to be responsive to screen width -->
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{Url( 'public/dist/css/bootstrap-theme.css' ) }}">
  <!-- Bootstrap rtl -->
  <link rel="stylesheet" href="{{Url( 'public/dist/css/rtl.css' ) }}">
  <!-- babakhani datepicker -->
  <link rel="stylesheet" href="{{Url( 'public/dist/css/persian-datepicker-0.4.5.min.css' ) }}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{Url( 'public/bower_components/font-awesome/css/font-awesome.min.css' ) }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{Url( 'public/bower_components/Ionicons/css/ionicons.min.css' ) }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{Url( 'public/bower_components/bootstrap-daterangepicker/daterangepicker.css' ) }}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{Url( 'public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css' ) }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{Url( 'public/plugins/iCheck/all.css' ) }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{Url( 'public/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css' ) }}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{Url( 'public/plugins/timepicker/bootstrap-timepicker.min.css' ) }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{Url( 'public/bower_components/select2/dist/css/select2.min.css' ) }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{Url( 'public/dist/css/AdminLTE.css' ) }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{Url( 'public/dist/css/skins/_all-skins.min.css' ) }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <!-- Google reCAPTCHA -->
  <script src="https://www.google.com/recaptcha/api.js?hl=fa" async defer></script>
  <!-- jQuery 3 -->
<script src="{{Url( 'public/bower_components/jquery/dist/jquery.min.js' ) }}"></script>
<script src="{{ url('public/dist/js/num2persian/num2persian.js') }}" type="text/javascript"></script>
  
</head>
<body class="hold-transition login-page" >
    @include('layouts.error')
    @yield('content')

<!-- /.login-box -->


<!-- Bootstrap 3.3.7 -->
<script src="{{Url( 'public/bower_components/bootstrap/dist/js/bootstrap.min.js' ) }}"></script>
<!-- Select2 -->
<script src="{{Url( 'public/bower_components/select2/dist/js/select2.full.min.js' ) }}"></script>
<!-- InputMask -->
<script src="{{Url( 'public/plugins/input-mask/jquery.inputmask.js' ) }}"></script>
<script src="{{Url( 'public/plugins/input-mask/jquery.inputmask.date.extensions.js' ) }}"></script>
<script src="{{Url( 'public/plugins/input-mask/jquery.inputmask.extensions.js' ) }}"></script>
<!-- date-range-picker -->
<script src="{{Url( 'public/bower_components/moment/min/moment.min.js' ) }}"></script>
<script src="{{Url( 'public/bower_components/bootstrap-daterangepicker/daterangepicker.js' ) }}"></script>
<!-- bootstrap datepicker -->
<script src="{{Url( 'public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js' ) }}"></script>
<!-- bootstrap color picker -->
<script src="{{Url( 'public/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js' ) }}"></script>
<!-- bootstrap time picker -->
<script src="{{Url( 'public/plugins/timepicker/bootstrap-timepicker.min.js' ) }}"></script>
<!-- SlimScroll -->
<script src="{{Url( 'public/bower_components/jquery-slimscroll/jquery.slimscroll.min.js' ) }}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{Url( 'public/plugins/iCheck/icheck.min.js' ) }}"></script>
<!-- FastClick -->
<script src="{{Url( 'public/bower_components/fastclick/lib/fastclick.js' ) }}"></script>
<!-- AdminLTE App -->
<script src="{{Url( 'public/dist/js/adminlte.min.js' ) }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{Url( 'public/dist/js/demo.js' ) }}"></script>
<!-- babakhani datepicker -->
<script src="{{Url( 'public/dist/js/persian-date-0.1.8.min.js' ) }}"></script>
<script src="{{Url( 'public/dist/js/persian-datepicker-0.4.5.min.js' ) }}"></script>


<!-- Page script -->
<script>
    $(document).ready(function () {
        $('#tarikh').persianDatepicker({
            altField: '#tarikhAlt',
            altFormat: 'X',
            format: 'D MMMM YYYY HH:mm a',
            observer: true,
            timePicker: {
                enabled: true
            },
        });
    });
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
<script src="{{Url( 'public/plugins/iCheck/icheck.min.js' ) }}"></script>
<script>
  /* $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  }); */
</script>
@yield('script')
</body>
</html>
