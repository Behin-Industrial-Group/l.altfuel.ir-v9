<?php 

use App\CustomClasses\UserInfo;
use App\CustomClasses\Access;
use App\CustomClasses\NumberOf;
use App\Models\IssuesCatagoryModel;
use App\Models\VideosCatagoriesModel;

$user = Auth::user();
$issues_catagories = IssuescatagoryModel::get();
$videosCatagories = VideosCatagoriesModel::get();
?>
<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-right image">
              <img src="{{ Url('public/dist/img/avatar5.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-right info" style="color:white">
              <p>{{$user->name}}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> آنلاین</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
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
                    <li><a href="{{ Url('admin/addqr') }}"><i class="fa fa-minus"></i>افزودن بارکد</a></li>
                    <li><a href="{{ Url('admin/createqr') }}"><i class="fa fa-minus"></i>ساخت بارکد</a></li>
                    <li><a href="{{ Url('admin/printqr') }}"><i class="fa fa-minus"></i>چاپ بارکد</a></li>
                  </ul>
                </li>
            @endif
            <!--
            @if(Access::checkView('archive_add'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-table"></i> <span>بایگانی</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ Url('admin/addarchive') }}"><i class="fa fa-minus"></i>افزودن پرونده</a></li>
                    <li><a href="{{ Url('admin/addstatus') }}"><i class="fa fa-minus"></i>افزودن وضعیت</a></li>
                  </ul>
                </li>
            @endif
            -->
            @if(Access::checkView('blog'))
                <li>
                    <a href="{{ route('binshopsblog.admin.index') }}"><i class="fa fa-book"></i> <span>محتوا</span></a>
                </li>
            @endif
            <li class="treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i> <span>مراکز</span>
                
                <span class="pull-left-container">
                  <i class="label pull-right bg-green">جدید</i>
                  <i class="fa fa-angle-right pull-left"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ route('agency.list-form') }}"><i class="fa fa-minus"></i>همه</a></li>
              </ul>
            </li>
            {{-- @if(Access::checkView('Marakez_index'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>خدمات فنی</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/marakez') }}"><i class="fa fa-minus"></i>مراکز</a></li>
                        <li><a href="{{ Url('admin/marakez/fin') }}"><i class="fa fa-minus"></i>همه</a></li>
                        <li><a href="{{ Url('admin/addmarkaz') }}"><i class="fa fa-minus"></i>افزودن مرکز</a></li>
                  </ul>
                </li>
            @endif --}}
            {{-- @if(Access::checkView('Hidro_index'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>هیدرو استاتیک</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/hidro') }}"><i class="fa fa-minus"></i>مراکز هیدرو</a></li>
                        <li><a href="{{ route('show-hidro-fin-form') }}"><i class="fa fa-minus"></i>هیدرو - لیست مالی</a></li>
                        <li><a href="{{ Url('admin/hidro/add') }}"><i class="fa fa-minus"></i>افزودن مرکز</a></li>
                  </ul>
                </li>
            @endif --}}
            {{-- @if(Access::checkView('kamfeshar_list'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>کم فشار</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ Url('admin/kamfeshar') }}"><i class="fa fa-minus"></i>مراکز کم فشار</a></li>
                    <li><a href="{{ route('show_fin_from_view') }}"><i class="fa fa-minus"></i>کم فشار - لیست مالی</a></li>
                    <li><a href="{{ Url('admin/kamfeshar/add') }}"><i class="fa fa-minus"></i>افزودن مرکز کم فشار</a></li>
                  </ul>
                </li>
            @endif --}}
            <!--
            @if(Access::checkView('inspection_list'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>پیمانکاران</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/contractors') }}"><i class="fa fa-minus"></i>پیمانکاران تبدیل</a></li>
                        <li><a href="{{ Url('admin/contractors/add') }}"><i class="fa fa-minus"></i>افزودن پیمانکار تبدیل  </a></li>
                  </ul>
                </li>
            @endif
            -->
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
                        <li><a href="<?php echo Url("admin/issues/show/$catagory->name") ?>"><i class="label pull-left bg-red">{{NumberOf::Ticket($catagory->name)}}</i><i class="fa fa-minus"></i>{{$catagory->fa_name}}</a></li>
                      @endforeach
                        <hr>
                        <li><a href="{{ Url('admin/issues/show/irngvagancy') }}"><i class="label pull-left bg-red">{{NumberOf::Ticket('irngvagancy')}}</i><i class="fa fa-minus"></i>مراکز irngv</a></li>
                        <hr>
                        <li><a href="{{ Url('admin/issues/catagories') }}"><i class="fa fa-minus"></i>دسته بندی ها</a></li>
                        <li><a href="{{ Url('admin/issues/createIssue') }}"><i class="fa fa-minus"></i>ایجاد تیکت</a></li>
                  </ul>
                </li>
            @endif
            <!--
            <li class="treeview">
              <a href="#">
                <i class="fa fa-envelope"></i> <span>الگوهای ارسال پیامک</span>
                <span class="pull-left-container">
                  <i class="fa fa-angle-right pull-left"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ Url('admin/smstemplate') }}"><i class="fa fa-minus"></i>مالیات</a></li>
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
                    <li><a href="{{ Url('admin/forms/parvane') }}"><i class="fa fa-minus"></i>صدور پروانه</a></li>
              </ul>
            </li>
            -->
            @if(Access::checkView('user_show_all'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-envelope"></i> <span>کاربران</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/user/all') }}"><i class="fa fa-minus"></i>همه</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('report'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-envelope"></i> <span>گزارش</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        @if(Access::checkView('report_issue'))
                        <li><a href="{{ Url('admin/report/ticket') }}"><i class="fa fa-minus"></i>تیکت</a></li>
                        @endif
                        @if(Access::checkView('report_call'))
                        <li class="treeview">
                          <a href="">
                            <i class="fa fa-minus"></i> <span>تماس</span>
                            <span class="pull-left-container">
                              <i class="fa fa-angle-right pull-left"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu" style="display: none;">
                            <li><a href="{{ Url('admin/report/call') }}"><i class="fa fa-minus"></i>ایجاد</a></li>
                            <li><a href="{{ Url('admin/report/call/show') }}"><i class="fa fa-minus"></i>مشاهده</a></li>
                          </ul>
                        </li>
                        @endif
                        @if(Access::checkView('report_license'))
                        <li><a href="{{ Url('admin/report/license') }}"><i class="fa fa-minus"></i>پروانه کسب</a></li>
                        @endif
                        @if(Access::checkView('irngv_poll_report'))
                          <li><a href="{{ route('report.irngv.poll') }}"><i class="fa fa-minus"></i>نظرسنجی irngv</a></li>
                        @endif
                  </ul>
                </li>
            @endif
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
                        <li><a href="<?php echo  Url("admin/videos/show/$c->name") ?>"><i class="fa fa-minus"></i>{{ $c->fa_name }}</a></li>
                      @endforeach
                        <li><a href="{{ Url('admin/videos/add') }}"><i class="fa fa-minus"></i>افزودن ویدیو</a></li>
                        <li><a href="{{ Url('admin/videos/addCatagory') }}"><i class="fa fa-minus"></i>افزودن دسته بندی</a></li>
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
                        <li><a href="{{ Url('admin/ins/asign/ins/form') }}"><i class="fa fa-minus"></i>درخواست جدید</a></li>
                        <li><a href="{{ Url('admin/ins/show/all') }}"><i class="fa fa-minus"></i>لیست درخواست ها</a></li>
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
                        <li><a href="{{ Url('admin/request/asign/ins/show/all') }}"><i class="fa fa-minus"></i>تخصیص بازرس</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('robot'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-envelope"></i> <span>ربات پاسخگویی</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ Url('admin/robot/add') }}"><i class="fa fa-minus"></i>افزودن دسته جدید</a></li>
                        <li><a href="{{ Url('admin/robot/edit') }}"><i class="fa fa-minus"></i>اصلاح پاسخ ها</a></li>
                  </ul>
                </li>
            @endif
            @if(Access::checkView('irngv'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-envelope"></i> <span>اطلاعات دریافتی از irngv</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                      @if(Access::checkView('irngv_recive_car_info'))
                        <li><a href="{{ route('admin.irngv.show.list') }}"><i class="fa fa-minus"></i>اطلاعات دریافتی</a></li>
                      @endif
                      @if(Access::checkView('irngv_poll_info'))
                        <li><a href="{{ route('admin.irngv.show.answers') }}"><i class="fa fa-minus"></i>اطلاعات نظرسنجی </a></li>
                      @endif
                  </ul>
                </li>
            @endif
            @if(Access::checkView('Disable_App'))
              <li>
                <a href="{{ Url('admin/disable') }}"><i class="fa fa-book"></i> <span>غیرفعال کردن نرم افزار</span></a>
              </li>
            @endif
            @if(Access::checkView('show_options'))
              <li>
                <a href="{{ Url('admin/options') }}"><i class="fa fa-book"></i> <span>گزینه های بیشتر</span></a>
              </li>
            @endif
            @if(Access::checkView('hamayesh'))
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>همایش</span>
                    <span class="pull-left-container">
                      <i class="fa fa-angle-right pull-left"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ route('add-class-form') }}"><i class="fa fa-minus"></i>افزودن دوره آموزشی</a></li>
                        <li><a href="{{ route('hamayesh-list') }}"><i class="fa fa-minus"></i>لیست ثبت نامی ها</a></li>

                  </ul>
                </li>
            @endif
          </ul>
        </section>
        <!-- /.sidebar -->
  </aside> 