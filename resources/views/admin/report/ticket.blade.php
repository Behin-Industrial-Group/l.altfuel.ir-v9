<?php

use App\Models\IssuesCatagoryModel;
use App\CustomClasses\IssuesCatagory;

?>
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <p width='50'>
                    امروز: 
                    <span dir='ltr'>{{$date->formatDate()}}</span>
                </p>
            </div>
            <div class="box-body">
                    

                <hr/>
                <div class="col-sm-12">
                    <style>
                        td,th{
                            border-left: solid 1px black;
                            border-bottom: solid 1px black;
                        }
                    </style>
                    
                    <!--TOTAL -->
                    <table class="table table-response" style="background:#99ffc0">
                        <tr>
                            <th>ردیف</th>
                            <th>دسته بندی</th>
                            <th>کل تیکتها</th>
                            <th>پاسخ داده</th>
                            <th>پاسخ نداده</th>
                            <th>کل نیاز به پیگیری ها</th>
                            <th>نیاز به پیگیری بدون پاسخ</th>
                            <th>نیاز به پیگیری پاسخ داده شده</th>
                            <th>عدم نیاز به پاسخ</th>
                            <th>درصد پاسخ</th>
                        </tr>
                        <tr>
                            <th>1</th>
                            <th>همه</th>
                            <td>{{$report['total']['total']}}</td>
                            <td>{{$report['total']['total'] - $report['total']['unanswer']}}</td>
                            <td>{{$report['total']['unanswer']}}</td>
                            <td>{{$report['total']['tracking']}}</td>
                            <td>{{$report['total']['unanswer_tracking']}}</td>
                            <td>{{$report['total']['tracking'] - $report['total']['unanswer_tracking']}}</td>
                            <td>{{$report['total']['junk']}}</td>
                            <td>
                                <?php if($report["total"]['total'] == 0) $report["total"]['total'] =1 ?>
                                {{(int)
                                    (($report["total"]['total'] 
                                    - $report["total"]['unanswer'] 
                                    - $report["total"]['unanswer_tracking'])*100 
                                    / $report["total"]['total'])
                                }}%
                            </td>
                        </tr>
                        
                        <?php 
                        $catagories = IssuesCatagoryModel::get();
                        $i = 2;
                        ?>
                        @foreach($catagories as $catagory)
                        <tr>
                            <th>{{$i}}</th>
                            <th>{{$catagory->fa_name}}</th>
                            <td>{{$report["$catagory->name"]['total']}}</td>
                            <td>{{$report["$catagory->name"]['total'] - $report["$catagory->name"]['unanswer']}}</td>
                            <td>{{$report["$catagory->name"]['unanswer']}}</td>
                            <td>{{$report["$catagory->name"]['tracking']}}</td>
                            <td>{{$report["$catagory->name"]['unanswer_tracking']}}</td>
                            <td>{{$report["$catagory->name"]['tracking'] - $report["$catagory->name"]['unanswer_tracking']}}</td>
                            <td>{{$report["$catagory->name"]['junk']}}</td>
                            <td>
                                <?php if($report["$catagory->name"]['total'] == 0) $report["$catagory->name"]['total'] =1 ?>
                                {{(int)
                                    (($report["$catagory->name"]['total'] 
                                    - $report["$catagory->name"]['unanswer'] 
                                    - $report["$catagory->name"]['unanswer_tracking'])*100 
                                    / $report["$catagory->name"]['total'])
                                }}%
                            </td>
                            <?php $i++ ?>
                        </tr>
                        @endforeach
                        <tr>
                            <th>{{$i}}</th>
                            <th>مراکز</th>
                            <td>{{$report["agancy"]['total']}}</td>
                            <td>{{$report["agancy"]['total'] - $report["agancy"]['unanswer']}}</td>
                            <td>{{$report["agancy"]['unanswer']}}</td>
                            <td>{{$report["agancy"]['tracking']}}</td>
                            <td>{{$report["agancy"]['unanswer_tracking']}}</td>
                            <td>{{$report["agancy"]['tracking'] - $report["agancy"]['unanswer_tracking']}}</td>
                            <td>{{$report["agancy"]['junk']}}</td>
                            <td>
                                <?php if($report["agancy"]['total'] == 0) $report["agancy"]['total'] =1 ?>
                                {{
                                (int)(($report["agancy"]['total'] 
                                        - $report["agancy"]['unanswer'] 
                                        - $report["agancy"]['unanswer_tracking'])*100 
                                        / $report["agancy"]['total'])
                                }}%
                            </td>
                            <?php $i++ ?>
                        </tr>
                        <p>
                            توضیحات:
                        </p>
                        <ul>
                            <li>هم تیکت هایی که تاریخ ثبت شمسی و هم تاریخ ثبت میلادی دارند، شمارش شده اند</li>
                        </ul>
                    </table>
                    </hr>
                    
                    <!-- WEEKLY PER CATAGORY-->
                    <table class="table table-response" style="background:#b5d1ff">
                        <h3>
                            گزارش هفتگی در هر دسته بندی
                        </h3>
                        <tr>
                            <th>دسته بندی</th>
                            <th>کل</th>
                            <th>پاسخ نداده</th>
                            <th>نیاز به پیگیری بدون پاسخ</th>
                            <th>عملکرد</th>
                        </tr>
                        @foreach($catagories as $catagory)
                        <tr>
                            <th>{{$catagory->fa_name}}</th>
                            <td>{{$numberPerCatagoryWeekly[$catagory->name]['total']}}</td>
                            <td>{{$numberPerCatagoryWeekly[$catagory->name]['unanswer']}}</td>
                            <td>{{$numberPerCatagoryWeekly[$catagory->name]['trackingUnanswer']}}</td>
                            <td>
                                @if($numberPerCatagoryWeekly[$catagory->name]['total'] != 0)
                                %
                                {{  (int) 
                                    (($numberPerCatagoryWeekly[$catagory->name]['total'] 
                                    - $numberPerCatagoryWeekly[$catagory->name]['unanswer']
                                    - $numberPerCatagoryWeekly[$catagory->name]['trackingUnanswer'])*100
                                    / $numberPerCatagoryWeekly[$catagory->name]['total']) 
                                }}
                                @endif
                            </td>
                        </tr>    
                        @endforeach
                        <tr>
                            <th>مراکز</th>
                            <td>{{$numberPerCatagoryWeekly["agancy"]["total"]}}</td>
                            <td>{{$numberPerCatagoryWeekly['agancy']['unanswer']}}</td>
                            <td>{{$numberPerCatagoryWeekly['agancy']['trackingUnanswer']}}</td>
                            <td>
                                @if($numberPerCatagoryWeekly['agancy']['total'] != 0)
                                %
                                {{  (int) 
                                    (($numberPerCatagoryWeekly['agancy']['total'] 
                                    - $numberPerCatagoryWeekly['agancy']['unanswer']
                                    - $numberPerCatagoryWeekly['agancy']['trackingUnanswer'])*100
                                    / $numberPerCatagoryWeekly['agancy']['total']) 
                                }}
                                @endif
                            </td>
                        </tr>  
                        <p>
                            توضیحات:
                        </p>
                        <ul>
                            <li>فقط تیکت هایی که تاریخ ثبت آنها شمسی است، شمارش شده اند</li>
                        </ul>
                    </table>
                    <hr />
                    
                    <!-- PER CATAGORY BEFORE LAST WEEK-->
                    <table class="table table-response" style="background:#3bd1ff">
                        <h3>
                            گزارش گذشته در هر دسته بندی
                        </h3>
                        <tr>
                            <th>دسته بندی</th>
                            <th>کل</th>
                            <th>پاسخ نداده</th>
                            <th>نیاز به پیگیری بدون پاسخ</th>
                            <th>عملکرد</th>
                        </tr>
                        @foreach($catagories as $catagory)
                        <tr>
                            <th>{{$catagory->fa_name}}</th>
                            <td>{{$numberPerCatagoryBeforeLastWeek[$catagory->name]['total']}}</td>
                            <td>{{$numberPerCatagoryBeforeLastWeek[$catagory->name]['unanswer']}}</td>
                            <td>{{$numberPerCatagoryBeforeLastWeek[$catagory->name]['trackingUnanswer']}}</td>
                            <td>
                                @if($numberPerCatagoryBeforeLastWeek[$catagory->name]['total'] != 0)
                                %
                                {{  (int) 
                                    (($numberPerCatagoryBeforeLastWeek[$catagory->name]['total'] 
                                    - $numberPerCatagoryBeforeLastWeek[$catagory->name]['unanswer']
                                    - $numberPerCatagoryBeforeLastWeek[$catagory->name]['trackingUnanswer'])*100
                                    / $numberPerCatagoryBeforeLastWeek[$catagory->name]['total']) 
                                }}
                                @endif
                            </td>
                        </tr>    
                        @endforeach
                        <tr>
                            <th>مراکز</th>
                            <td>{{$numberPerCatagoryBeforeLastWeek["agancy"]["total"]}}</td>
                            <td>{{$numberPerCatagoryBeforeLastWeek['agancy']['unanswer']}}</td>
                            <td>{{$numberPerCatagoryBeforeLastWeek['agancy']['trackingUnanswer']}}</td>
                            <td>
                                @if($numberPerCatagoryBeforeLastWeek['agancy']['total'] != 0)
                                %
                                {{  (int) 
                                    (($numberPerCatagoryBeforeLastWeek['agancy']['total'] 
                                    - $numberPerCatagoryBeforeLastWeek['agancy']['unanswer']
                                    - $numberPerCatagoryBeforeLastWeek['agancy']['trackingUnanswer'])*100
                                    / $numberPerCatagoryBeforeLastWeek['agancy']['total']) 
                                }}
                                @endif
                            </td>
                        </tr>  
                        <p>
                            توضیحات:
                        </p>
                        <ul>
                            <li>فقط تیکت هایی که تاریخ ثبت آنها شمسی است، شمارش شده اند</li>
                        </ul>
                    </table>
                    <hr />
                    
                    <!-- WEEKLY PER USER -->
                    <table class="table table-response" style="background:#ffe291">
                        <h3>
                            گزارش هفتگی برای هر کاربر
                        </h3>
                        <tr>
                            <th>کاربر</th>
                            <th>پاسخ داده</th>
                            <th>نیاز به پیگیری پاسخ نداده</th>
                        </tr>
                        @foreach($users as $user)
                        <tr>
                            <th>{{$user->display_name}}</th>
                            <td>{{$numberPerUserWeekly[$user->id]['answer']}}</td>
                            <td>{{$numberPerUserWeekly[$user->id]['trackingUnanswer']}}</td>
                        </tr>    
                        @endforeach
                        <p>
                            توضیحات:
                        </p>
                        <ul>
                            <li>برای یک تیکت ممکن است دو بار پاسخ داده شود. در شمارش دو بار محاسبه میشود</li>
                            <li>برای یک تیکت ممکن است دو کارشناس پاسخ دهند. برای هر دو یک پاسخ داده در نظر گرفته می شود.</li>
                        </ul>
                    </table>
                    <hr>
                    
                    <!-- PER USER Before Last Week-->
                    <table class="table table-response" style="background:#f5cb42">
                        <h3>
                            گزارش گذشته برای هر کاربر
                        </h3>
                        <tr>
                            <th>کاربر</th>
                            <th>پاسخ داده</th>
                            <th>نیاز به پیگیری پاسخ نداده</th>
                        </tr>
                        @foreach($users as $user)
                        <tr>
                            <th>{{$user->display_name}}</th>
                            <td>{{$numberPerUserBeforeLastWeek[$user->id]['answer']}}</td>
                            <td>{{$numberPerUserBeforeLastWeek[$user->id]['trackingUnanswer']}}</td>
                        </tr>    
                        @endforeach
                        <p>
                            توضیحات:
                        </p>
                        <ul>
                            <li>برای یک تیکت ممکن است دو بار پاسخ داده شود. در شمارش دو بار محاسبه میشود</li>
                            <li>برای یک تیکت ممکن است دو کارشناس پاسخ دهند. برای هر دو یک پاسخ داده در نظر گرفته می شود.</li>
                        </ul>
                    </table>
                    <hr>
                    
                    <!-- REGISTER AND ANSWER ISSUES PER CATAGORY PER DAY -->
                    <table class="table table-response">
                        <h3>
                            تعداد تیکت های ثبت شده و پاسخ داده شده در هر دسته بندی در یک هفته گذشته
                        </h3>
                        <?php
                        $date = $date->subDays(7); 
                        $row =1;
                        echo "<tr>";
                        echo "<td>دسته بندی/ روز</td>";
                        for($i=7;$i>0;$i--)
                        {
                            switch($date->dayOfWeek)
                              {
                                  case 0:
                                      $dayOfWeek = 'شنبه';
                                      break;
                                  case 1:
                                      $dayOfWeek = 'یکشنبه';
                                      break;
                                  case 2:
                                      $dayOfWeek = 'دوشنبه';
                                      break;
                                  case 3:
                                      $dayOfWeek = 'سه شنبه';
                                      break;
                                  case 4:
                                      $dayOfWeek = 'چهارشنبه';
                                      break;
                                  case 5:
                                      $dayOfWeek = 'پنج شنبه';
                                      break;
                                  case 6:
                                      $dayOfWeek = 'جمعه';
                                      break;
                              }
                            echo "<th colspan='2'>$dayOfWeek $date->year/$date->month/$date->day</th>";
                            $date->addDay()->formatDate();
                        }
                        echo "</tr>";
                        echo "</tr>";
                        echo "<td>وضعیت</td>";
                        for($i=7;$i>0;$i--)
                        {
                            echo "<td>پاسخ</td>";
                            echo "<td>کل</td>";
                        }
                        echo "</tr>";
                        foreach($catagories as $catagory){
                            echo "<tr>";
                            echo "<th>$catagory->fa_name</th>";
                            $date = $date->subDays(7);  
                              for($i=7;$i>0;$i--)
                              {
                                  $d = $date->formatDate();
                                  echo "<td>",$chartData["$catagory->name"]["$d"]['answer'], "</td>";
                                  echo "<td>" ,$chartData["$catagory->name"]["$d"]['total'] , "</td>";
                                  $date->addDay();
                              }
                            echo "</tr>";
                        }
                        
                        ?>
                    </table>
                    <hr/>
                    
                    <!-- REGISTER AND ANSWER ISSUES PER USER PER DAY -->
                    <table class="table table-response">
                        <h3>
                            تعداد تیکت های ثبت شده و پاسخ داده شده همان روز توسط هر کاربر در یک هفته گذشته
                        </h3>
                        <?php
                        $date = $date->subDays(7); 
                        $row =1;
                        echo "<tr>";
                        echo "<td>دسته بندی/ روز</td>";
                        for($i=7;$i>0;$i--)
                        {
                            switch($date->dayOfWeek)
                              {
                                  case 0:
                                      $dayOfWeek = 'شنبه';
                                      break;
                                  case 1:
                                      $dayOfWeek = 'یکشنبه';
                                      break;
                                  case 2:
                                      $dayOfWeek = 'دوشنبه';
                                      break;
                                  case 3:
                                      $dayOfWeek = 'سه شنبه';
                                      break;
                                  case 4:
                                      $dayOfWeek = 'چهارشنبه';
                                      break;
                                  case 5:
                                      $dayOfWeek = 'پنج شنبه';
                                      break;
                                  case 6:
                                      $dayOfWeek = 'جمعه';
                                      break;
                              }
                            echo "<th colspan='2'>$dayOfWeek $date->year/$date->month/$date->day</th>";
                            $date->addDay()->formatDate();
                        }
                        echo "</tr>";
                        echo "</tr>";
                        echo "<td>وضعیت</td>";
                        for($i=7;$i>0;$i--)
                        {
                            echo "<td>پاسخ</td>";
                            echo "<td>کل</td>";
                        }
                        echo "</tr>";
                        foreach($catagories as $catagory){
                            echo "<tr>";
                            echo "<th>$catagory->name</th>";
                            $date = $date->subDays(7);  
                              for($i=7;$i>0;$i--)
                              {
                                  $d = $date->formatDate();
                                  echo "<td>",$numberPerCatagoryPerDay["$catagory->name"]["$d"]['answer'], "</td>";
                                  echo "<td>" ,$numberPerCatagoryPerDay["$catagory->name"]["$d"]['total'], "</td>";
                                  $date->addDay();
                              }
                            echo "</tr>";
                        }
                        
                        ?>
                    </table>
                    <hr />
                    
                    <table class="table table-response">
                        <h3>
                            تعداد تیکت پاسخ داده شده و نیاز به پیگیری شده در همان روز توسط هر کاربر در یک هفته گذشته
                        </h3>
                        <?php
                        $date = $date->subDays(7); 
                        $row =1;
                        echo "<tr>";
                        echo "<td>دسته بندی/ روز</td>";
                        for($i=7;$i>0;$i--)
                        {
                            switch($date->dayOfWeek)
                              {
                                  case 0:
                                      $dayOfWeek = 'شنبه';
                                      break;
                                  case 1:
                                      $dayOfWeek = 'یکشنبه';
                                      break;
                                  case 2:
                                      $dayOfWeek = 'دوشنبه';
                                      break;
                                  case 3:
                                      $dayOfWeek = 'سه شنبه';
                                      break;
                                  case 4:
                                      $dayOfWeek = 'چهارشنبه';
                                      break;
                                  case 5:
                                      $dayOfWeek = 'پنج شنبه';
                                      break;
                                  case 6:
                                      $dayOfWeek = 'جمعه';
                                      break;
                              }
                            echo "<th colspan='2'>$dayOfWeek $date->year/$date->month/$date->day</th>";
                            $date->addDay()->formatDate();
                        }
                        echo "</tr>";
                        echo "</tr>";
                        echo "<td>وضعیت</td>";
                        for($i=7;$i>0;$i--)
                        {
                            echo "<td>پاسخ</td>";
                            echo "<td>ن.ب.پ</td>";
                        }
                        echo "</tr>";
                        foreach($users as $user){
                            echo "<tr>";
                            echo "<th>$user->display_name</th>";
                            $date = $date->subDays(7);  
                              for($i=7;$i>0;$i--)
                              {
                                  $d = $date->formatDate();
                                  echo "<td>",$numberPerUserPerDay["$user->display_name"]["$d"]['answer'], "</td>";
                                  echo "<td>" ,$numberPerUserPerDay["$user->display_name"]["$d"]['trackingLater'], "</td>";
                                  $date->addDay();
                              }
                            echo "</tr>";
                        }
                        
                        ?>
                    </table>
                    <hr />
                    
                    
                </div>
            </div>
        </div>
        <!--
        <div class="box">
            <div class="box-header">
                تعداد کل تیکت های ثبت شده توسط متقاضی در هر روز در هر دسته بندی
                <p width='50'>
                    امروز: 
                    <span dir='ltr'>{{$date->formatDate()}}</span>
                </p>
                <p>
                    @foreach($catagories as $catagory)
                        <p style="color: <?php echo "#",substr(dechex(crc32($catagory->name)*2), 0, 6) ?>">{{$catagory->name}}</p>
                    @endforeach
                </p>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="barChart" style="height: 474px; width: 478px;" width="1195" height="600"></canvas>
                </div>
            </div>
        </div>
        -->
        <div class="box">
            <div class="box-header">
                متوسط زمان پاسخگویی در هر دسته بندی (به روز) از ابتدای سال 1399 به بعد
                <p width='50'>
                    امروز: 
                    <span dir='ltr'>{{$date->formatDate()}}</span>
                </p>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="avgAnsweredTime" style="height: 474px; width: 478px;" width="1195" height="600"></canvas>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <p>
                    متوسط تعداد کارکترهایی که برای هر پاسخ توسط هر واحد ثبت شده است. از ابتدای سال 1399 به بعد
                </p>
                <p width='50'>
                    امروز: 
                    <span dir='ltr'>{{$date->formatDate()}}</span>
                </p>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="avgAnsweredChars" style="height: 474px; width: 478px;" width="1195" height="600"></canvas>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <p>
                    تعداد تیکت های پاسخ داده شده توسط هر کاربر
                </p>
                <p width='50'>
                    امروز: 
                    <span dir='ltr'>{{$date->formatDate()}}</span>
                </p>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="numberOfAnsweredIssues" style="height: 474px; width: 478px;" width="1195" height="600"></canvas>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <p>
                    تعداد تیکت های پاسخ داده شده توسط هر کاربر
                </p>
                <p width='50'>
                    امروز: 
                    <span dir='ltr'>{{$date->formatDate()}}</span>
                </p>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="numberOfCharsOfAnsweredIssues" style="height: 474px; width: 478px;" width="1195" height="600"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
<script>
    $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
        /*
        var barChartData = {
          labels  : [
              <?php
              $date = $date->subDays(7);    
              for($i=7;$i>0;$i--)
              {
                  switch($date->dayOfWeek)
                  {
                      case 0:
                          $dayOfWeek = 'شنبه';
                          break;
                      case 1:
                          $dayOfWeek = 'یکشنبه';
                          break;
                      case 2:
                          $dayOfWeek = 'دوشنبه';
                          break;
                      case 3:
                          $dayOfWeek = 'سه شنبه';
                          break;
                      case 4:
                          $dayOfWeek = 'چهارشنبه';
                          break;
                      case 5:
                          $dayOfWeek = 'پنج شنبه';
                          break;
                      case 6:
                          $dayOfWeek = 'جمعه';
                          break;
                  }
                  echo "'$dayOfWeek: ","$date->year/$date->month/$date->day'" , ",";
                  $date->addDay()->formatDate();
              }
              ?>
              ],
          datasets: [
              @foreach($catagories as $catagory)
                {
                  label               : "{{$catagory->name}}",
                  fillColor           : "<?php echo "#",substr(dechex(crc32($catagory->name)*2), 0, 6) ?>",
                  data                : [
                      <?php
                      $date = $date->subDays(7);  
                      for($i=7;$i>0;$i--)
                      {
                          $d = $date->formatDate();
                          echo $chartData["$catagory->name"]["$d"]['total'] , ",";
                          $date->addDay();
                      }
                      ?>
                      ],
                },
            @endforeach
          ]
        }
        */
        
        var avgAnsweredTime = {
             labels: [
                 @foreach($avgAnsweredTime as $ar)
                    "{{$ar['catagory_faname']}}",
                 @endforeach
             ],
             datasets: [
                 {
                     label : "avgTime",
                     fillColor: "green",
                     data : [
                         @foreach($avgAnsweredTime as $ar)
                            {{$ar['avg']}},
                         @endforeach
                         ],
                 }
             ],
         }
        
        var avgAnsweredChars = {
             labels: [
                 @foreach($avgAnsweredChars as $ar)
                    "{{$ar['catagory_faname']}}",
                 @endforeach
             ],
             datasets: [
                 {
                     label : "avgTime",
                     fillColor: "gray",
                     data : [
                         @foreach($avgAnsweredChars as $ar)
                            <?php echo round($ar['avg']) ."," ?>
                         @endforeach
                         ],
                 }
             ],
         }
         
        var numberOfAnsweredIssues = {
             labels: [
                 @foreach($numberOfAnsweredIssues as $ar)
                 <?php echo "'", $ar['name'] , "'"  ?>,
                 @endforeach
             ],
             datasets: [
                 {
                     label : "numberOfAnswered",
                     fillColor: "blue",
                     data : [
                         @foreach($numberOfAnsweredIssues as $ar)
                            <?php echo $ar['numberOfAnswered'] ."," ?>
                         @endforeach
                         ],
                 }
             ],
         }
         
         var numberOfCharsOfAnsweredIssues = {
             labels: [
                 @foreach($numberOfAnsweredIssues as $ar)
                 <?php echo "'", $ar['name'] , "'"  ?>,
                 @endforeach
             ],
             datasets: [
                 {
                     label : "avgChars",
                     fillColor: "green",
                     data : [
                         @foreach($numberOfAnsweredIssues as $ar)
                            <?php echo $ar['avgChars'] ."," ?>
                         @endforeach
                         ],
                 }
             ],
         }
        //-------------
        //- BAR CHART -
        //-------------
        /*
        var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
        var barChart                         = new Chart(barChartCanvas)
        var barChartData                     = barChartData
        
        barChart.Bar(barChartData,{
            showTooltips: false,
            onAnimationComplete: function () {
        
                var ctx = this.chart.ctx;
                ctx.font = this.scale.font;
                ctx.fillStyle = this.scale.textColor
                ctx.textAlign = "center";
                ctx.textBaseline = "bottom";
        
                this.datasets.forEach(function (dataset) {
                    dataset.bars.forEach(function (bar) {
                        ctx.fillText(bar.value, bar.x, bar.y - 5);
                    });
                })
            }
        })
        */
        //AVG ANSWERED TIME
        var avgTimeConvas = $('#avgAnsweredTime').get(0).getContext('2d')
        var avgTime = new Chart(avgTimeConvas)
        var avgTimeData = avgAnsweredTime
        
        avgTime.Bar(avgTimeData,{
            showTooltips: false,
            onAnimationComplete: function () {
        
                var ctx = this.chart.ctx;
                ctx.font = this.scale.font;
                ctx.fillStyle = this.scale.textColor
                ctx.textAlign = "center";
                ctx.textBaseline = "bottom";
        
                this.datasets.forEach(function (dataset) {
                    dataset.bars.forEach(function (bar) {
                        ctx.fillText(bar.value, bar.x, bar.y - 5);
                    });
                })
            }
        })
        
        //AVG ANSWERED Chars
        var avgCharsConvas = $('#avgAnsweredChars').get(0).getContext('2d')
        var avgChars = new Chart(avgCharsConvas)
        var avgCharsData = avgAnsweredChars
        
        avgChars.Bar(avgCharsData,{
            showTooltips: false,
            onAnimationComplete: function () {
        
                var ctx = this.chart.ctx;
                ctx.font = this.scale.font;
                ctx.fillStyle = this.scale.textColor
                ctx.textAlign = "center";
                ctx.textBaseline = "bottom";
        
                this.datasets.forEach(function (dataset) {
                    dataset.bars.forEach(function (bar) {
                        ctx.fillText(bar.value, bar.x, bar.y - 5);
                    });
                })
            }
        })
        
        //NUMBER OF ANSWERED ISSUES Chars
        var numberOfAnsweredIssuesConvas = $('#numberOfAnsweredIssues').get(0).getContext('2d')
        var numberOfAnsweredIssuesChart = new Chart(numberOfAnsweredIssuesConvas)
        var numberOfAnsweredIssuesData = numberOfAnsweredIssues
        
        numberOfAnsweredIssuesChart.Bar(numberOfAnsweredIssuesData,{
            showTooltips: false,
            onAnimationComplete: function () {
        
                var ctx = this.chart.ctx;
                ctx.font = this.scale.font;
                ctx.fillStyle = this.scale.textColor
                ctx.textAlign = "center";
                ctx.textBaseline = "bottom";
        
                this.datasets.forEach(function (dataset) {
                    dataset.bars.forEach(function (bar) {
                        ctx.fillText(bar.value, bar.x, bar.y - 5);
                    });
                })
            }
        })
        
        //NUMBER OF CHARS OF ANSWERED ISSUES 
        var numberOfCharsOfAnsweredIssuesConvas = $('#numberOfCharsOfAnsweredIssues').get(0).getContext('2d')
        var numberOfCharsOfAnsweredIssuesChart = new Chart(numberOfCharsOfAnsweredIssuesConvas)
        var numberOfCharsOfAnsweredIssuesData = numberOfCharsOfAnsweredIssues
        
        numberOfCharsOfAnsweredIssuesChart.Bar(numberOfCharsOfAnsweredIssuesData,{
            showTooltips: false,
            onAnimationComplete: function () {
        
                var ctx = this.chart.ctx;
                ctx.font = this.scale.font;
                ctx.fillStyle = this.scale.textColor
                ctx.textAlign = "center";
                ctx.textBaseline = "bottom";
        
                this.datasets.forEach(function (dataset) {
                    dataset.bars.forEach(function (bar) {
                        ctx.fillText(bar.value, bar.x, bar.y - 5);
                    });
                })
            }
        })
      })
</script>
@endsection