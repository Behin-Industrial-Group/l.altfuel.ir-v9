<?php
use Illuminate\Support\Facades\Auth;
use App\CustomClasses\UserInfo;
use App\CustomClasses\Access;

$user = Auth::user();
?>
<header class="main-header" style="color: white">
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



        <div class="navbar-custom-menu" style="color: white">
            
            <ul class="nav navbar-nav">
                @if(Access::checkView('send_sms'))
                    <li class="dropdown messages-menu">
                        <a href="{{ url('admin/send-sms') }}" style="padding: 0; margin: 10%">
                            <button class="btn btn-success">ارسال پیامک</button>
                        </a>
                    </li>
                @endif
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-danger" id="numberOfUnread">
                    <script>
                        $.get("{{url('admin/messages/number-of-unread')}}", function(data){
                            $('#numberOfUnread').html(data);
                        })
                    </script>
                </span>
                </a>
                <ul class="dropdown-menu">
                <li class="header"></li>
                
                <li class="footer"><a href="{{url('admin/messages/list')}}">نمایش تمام پیام ها</a></li>
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
                <img src="{{ Url('public/dist/img/avatar5.png') }}" class="user-image" alt="User Image">
                <span class="hidden-xs">
                    {{$user->name}} 
                    </span>
                </a>
                <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="{{ Url('public/dist/img/avatar5.png') }}" class="img-circle" alt="User Image">

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
                    <form method="POST" action="<?php echo url("/logout") ?>">
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
</header> 