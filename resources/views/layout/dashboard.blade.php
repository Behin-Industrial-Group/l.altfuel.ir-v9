<?php 

use App\CustomClasses\UserInfo;
use App\CustomClasses\Access;
use App\CustomClasses\NumberOf;
use App\IssuesCatagoryModel;
use App\VideosCatagoriesModel;

$user = Auth::user();
$issues_catagories = IssuescatagoryModel::get();
$videosCatagories = VideosCatagoriesModel::get();
?>
<html>
    
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
      @yield('title')
  </title>
  <style>
      @yield('custom_css')
  </style>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/dist/css/bootstrap-theme.css') }}">
  <!-- Bootstrap rtl -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/dist/css/rtl.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/bower_components/jvectormap/jquery-jvectormap.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/dist/css/AdminLTE.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/dist/css/skins/_all-skins.min.css') }}">
  <!-- babakhani datepicker -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/dist/css/persian-datepicker-0.4.5.min.css') }}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- iCheck for checkboxes an radio inputs -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/plugins/iCheck/all.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/plugins/timepicker/bootstrap-timepicker.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/bower_components/select2/dist/css/select2.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ Url('public/lte-theme/dist/css/AdminLTE.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  </head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    

      <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">پنل</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>کنترل پنل مدیریت</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>



      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"></li>
              
              <li class="footer"><a href="#">نمایش تمام پیام ها</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">اعلان جدید</li>
              
              <li class="footer"><a href="#">نمایش همه</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"></li>
              
              <li class="footer">
                <a href="#">نمایش همه</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ Url( 'public/lte-theme/dist/img/avatar5.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">
                  {{$user->name}}
                </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ Url( 'public/lte-theme/dist/img/avatar5.png') }}" class="img-circle" alt="User Image">

                <p>
                    {{$user->name}}             
                    <small>
                      {{ UserInfo::Level($user->level) }}
                    </small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">پروفایل</a>
                </div>
                <div class="pull-left">
                  <form method="POST" action="/logout">
                    @csrf
                    <input type="submit" class="btn btn-default btn-flat" value="خروج" >
                  </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>      <!-- right side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-right image">
              <img src="{{ Url('public/lte-theme/dist/img/avatar5.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-right info">
              <p>{{$user->name}}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> آنلاین</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="جستجو">
              <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree" >
            <li class="header">منو</li>
            @if(Access::checkView('dashboard'))
                <li>
                    <a href="{{ Url('admin') }}"><i class="fa fa-book"></i> <span>داشبورد</span></a>
                </li>
            @endif
            @if(Access::checkView('Lable_register'))
                <li>
                    <a href="{{ Url('admin/lable') }}"><i class="fa fa-book"></i> <span>برچسب ها</span></a>
                </li>
            @endif
            @if(Access::checkView('Bimeh_showAll'))
                <li>
                    <a href="{{ Url('admin/takmili/registerors') }}"><i class="fa fa-book"></i> <span>بیمه تکمیلی</span></a>
                </li>
            @endif
            @if(Access::checkView('lock_list'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-table"></i> <span>قفل سخت افزاری</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ Url('admin/addqr') }}"><i class="fa fa-circle-o"></i>افزودن بارکد</a></li>
                    <li><a href="{{ Url('admin/createqr') }}"><i class="fa fa-circle-o"></i>ساخت بارکد</a></li>
                    <li><a href="{{ Url('admin/printqr') }}"><i class="fa fa-circle-o"></i>چاپ بارکد</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('archive_add'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-table"></i> <span>بایگانی</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ Url('admin/addarchive') }}"><i class="fa fa-circle-o"></i>افزودن پرونده</a></li>
                    <li><a href="{{ Url('admin/addstatus') }}"><i class="fa fa-circle-o"></i>افزودن وضعیت</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('Marakez_index'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>خدمات فنی</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/marakez') }}"><i class="fa fa-circle-o"></i>مراکز</a></li>
                        <li><a href="{{ Url('admin/addmarkaz') }}"><i class="fa fa-circle-o"></i>افزودن مرکز</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('Hidro_addmarkaz'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>هیدرو استاتیک</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/hidro') }}"><i class="fa fa-circle-o"></i>مراکز هیدرو</a></li>
                        <li><a href="{{ Url('admin/hidro/add') }}"><i class="fa fa-circle-o"></i>افزودن مرکز</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('kamfeshar_list'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>کم فشار</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/kamfeshar') }}"><i class="fa fa-circle-o"></i>مراکز کم فشار</a></li>
                        <li><a href="{{ Url('admin/kamfeshar/add') }}"><i class="fa fa-circle-o"></i>افزودن مرکز کم فشار</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('inspection_list'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>پیمانکاران</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/contractors') }}"><i class="fa fa-circle-o"></i>پیمانکاران تبدیل</a></li>
                        <li><a href="{{ Url('admin/contractors/add') }}"><i class="fa fa-circle-o"></i>افزودن پیمانکار تبدیل  </a></li>
                  </ul>
                </li>
            @endif
            
            @if(Access::checkView('Issues_issue_show'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>تیکت</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                      @foreach($issues_catagories as $catagory)
                        <li><a href="<?php echo Url("admin/issues/$catagory->name") ?>"><i class="label pull-left bg-red">{{NumberOf::Ticket($catagory->name)}}</i><i class="fa fa-circle-o"></i>{{$catagory->fa_name}}</a></li>
                      @endforeach>
                        <li><a href="{{ Url('admin/issues/irngvagancy') }}"><i class="label pull-left bg-red">{{NumberOf::Ticket('irngvagancy')}}</i><i class="fa fa-circle-o"></i>مراکز irngv</a></li>
                        <hr>
                        <li><a href="{{ Url('admin/issues/duplicate') }}"><i class="fa fa-circle-o"></i>ثبت عدم نیاز به پاسخ برای تکراری ها</a></li>
                        <li><a href="{{ Url('admin/issues/catagories') }}"><i class="fa fa-circle-o"></i>دسته بندی ها</a></li>
                        <li><a href="{{ Url('admin/issues/createIssue') }}"><i class="fa fa-circle-o"></i>ایجاد تیکت</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('search_box'))
            <li class="treeview">
              <a href="#">
                <i class="fa fa-envelope"></i> <span>الگوهای ارسال پیامک</span>
                <span class="pull-left-container">
                  <i class="fa fa-angle-right pull-left"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ Url('admin/smstemplate') }}"><i class="fa fa-circle-o"></i>مالیات</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-envelope"></i> <span>فرم ها</span>
                <span class="pull-left-container">
                  <i class="fa fa-angle-right pull-left"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ Url('admin/forms/parvane') }}"><i class="fa fa-circle-o"></i>صدور پروانه</a></li>
              </ul>
            </li>
            @endif
            
            @can('Level1')
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-envelope"></i> <span>کاربران</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/user/all') }}"><i class="fa fa-circle-o"></i>همه</a></li>
                  </ul>
                </li>
            @endcan
            @can('Level1')
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-envelope"></i> <span>گزارش</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/report/ticket') }}"><i class="fa fa-circle-o"></i>تیکت</a></li>
                  </ul>
                </li>
            @endcan
            @if(Access::checkView('Videos_showListpublic'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>ویدیوهای آموزشی</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                      @foreach( $videosCatagories as $c )
                        <li><a href="<?php echo  Url("admin/videos/show/$c->name") ?>"><i class="fa fa-circle-o"></i>{{ $c->fa_name }}</a></li>
                      @endforeach
                        <li><a href="{{ Url('admin/videos/add') }}"><i class="fa fa-circle-o"></i>افزودن ویدیو</a></li>
                        <li><a href="{{ Url('admin/videos/addCatagory') }}"><i class="fa fa-circle-o"></i>افزودن دسته بندی</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('AsignInsRequest_form'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-envelope"></i> <span>تخصیص بازرس</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/ins/asign/ins/form') }}"><i class="fa fa-circle-o"></i>درخواست جدید</a></li>
                        <li><a href="{{ Url('admin/ins/show/all') }}"><i class="fa fa-circle-o"></i>لیست درخواست ها</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('Request_form'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-envelope"></i> <span>درخواست ها</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/request/asign/ins/show/all') }}"><i class="fa fa-circle-o"></i>تخصیص بازرس</a></li>
                  </ul>
                </li>
            @endif
          </ul>
        </section>
        <!-- /.sidebar -->
  </aside> 
  <div class="content-wrapper" style="min-height: 12600px;">
        <div id="loading" dir="ltr" style="display:none;">
            <img src='http://l.altfuel.ir/public/uploads/public/loading.gif' style="width:150px;border:1px solid black;position:fixed;top:10%;left:45%;z-index:100;background:#eb7d34" />
        </div>
    @if(Access::checkView('search_box'))
        <div class="row">
            <section class="col-sm-12">
            <div class="box box-info box-solid">
                <div class="box-header">
                    جستجو
                    <div class="pull-right box-tools">
                        <button data-toggle='collapse' data-target="#search_box"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body collapse" id="search_box">
                    <div class="col-sm-10">
                        <table class="table table-bordered">
                        <form class="from-control" method="get" action="{{ Url('/admin/search-box/') }}">
                            @csrf
                            <tr>
                                <div class="from-group">
                                    <td>
                                        <label>
                                            نام جدول:
                                        </label>
                                    </td>
                                    <td>
                                        <select class="select2" name="table_name" id="table_name" onchange="showTableColumns(this.value)" style="width:50%">
                                            <option value=""></option>
                                            <?php $tables = DB::select('SHOW TABLES'); ?>
                                            @foreach($tables as $table)
                                            <option value="{{ $table->Tables_in_altfueli_lable }}">{{ $table->Tables_in_altfueli_lable }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="from-group">
                                    <td>
                                        <label>
                                            ستون:
                                        </label>
                                    </td>
                                    <td>
                                        <select class="col-sm-4 select2" name="column_name" id="column_name" style="width:50%">
                                        </select>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="from-group">
                                    <td>
                                        <label>
                                            مقدار:
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" name="value" id="value" class="form-control">
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="from-group">
                                    <td>
                                        <div class="from-group">
                                            <input type="submit" value="جستجو" class="btn btn-info">
                                        </div>
                                    </td>
                                </div>
                            </tr>
                            
                        </form>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        </div>
        
        <script>
        function showTableColumns(str) {
          var xhttp;    
          if (str == "") {
            document.getElementById("column_name").innerHTML = "";
            return;
          }
          xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
                document.getElementById("loading").style.display = "block";
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("column_name").innerHTML = this.responseText;
                document.getElementById("loading").style.display = "none";
            }
          };
          xhttp.open("GET", <?php echo "'". Url('/admin/search-box/gettablecolumns') . "/'" ?> +str , true);
          xhttp.send();
        }
        </script>  
        
    @endif
    <section class="content">   
       @yield('content')
    </section>
  </div>
      
<footer class="main-footer text-left">
    <strong>Copyright &copy; 2019 <a href="http://altfuel.ir" target="_blank">ALTFUEL</a></strong>
  </footer>    
      
    </div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ Url('public/lte-theme/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ Url('public/lte-theme/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ Url('public/lte-theme/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ Url('public/lte-theme/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ Url('public/lte-theme/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ Url('public/lte-theme/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ Url('public/lte-theme/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ Url('public/lte-theme/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- bootstrap datepicker -->
<script src="{{ Url('public/lte-theme/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ Url('public/lte-theme/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- bootstrap time picker -->
<script src="{{ Url('public/lte-theme/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ Url('public/lte-theme/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ Url('public/lte-theme/plugins/iCheck/icheck.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ Url('public/lte-theme/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ Url('public/lte-theme/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ Url('public/lte-theme/dist/js/demo.js') }}"></script>
<!-- babakhani datepicker -->
<script src="{{ Url('public/lte-theme/dist/js/persian-date-0.1.8.min.js') }}"></script>
<script src="{{ Url('public/lte-theme/dist/js/persian-datepicker-0.4.5.min.js') }}"></script>
<!--ChartJs -->
<script src="{{ Url('public/lte-theme/bower_components/chart.js/Chart.js') }}"></script>
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
<script src="{{ Url('public/lte-theme/plugins/iCheck/icheck.min.js') }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<script>
    // Prevent to sending form data by enter 
    $(document).on("keydown", ":input:not(textarea)", function(event) {
        return event.key != "Enter";
    });
</script>

@yield("custom_script")

</body>
</html>    
