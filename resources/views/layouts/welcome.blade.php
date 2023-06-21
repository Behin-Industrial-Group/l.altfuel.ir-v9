<!DOCTYPE html>
<html lang="en">
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
<body>
	
	<div class="limiter">
		@include('layouts.alert')

		<div class="container-login100" style="background-image: url('{{ url('public/login/images/bg-01.jpg') }}');">
			@yield('content')
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
	<!--===============================================================================================-->
	<script src="{{ url('public/js/loader.js') }}"></script>
	<script src="{{ url('public/js/clearcach.js') }}"></script>
	<script src="{{ url('public/js/scripts.js') }}"></script>

	@yield('script')
</body>
</html>