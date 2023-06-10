@extends('layouts.app')

@section('content')
<div class="card">
    <a href="{{ Url('admin/report/call/show') }}"><button class="btn btn-danger">مشاهده</button></a>
</div>
    <div class="card table-responsive">
        <p id="test"></p>
        @include('includes.success')
        <form id="form" action="{{url('admin/report/call')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <table class="table table-stripped">
                <tr>
                    <td>تاریخ: </td>
                    <td colspan="2"><input name="date" list="date_list" id="date" class="form-control"></td>
                    
                </tr>
                <tr>
                    <td>
                        فایل اکسل: 
                    </td>
                    <td>
                        <input type="file" name="file" id="">
                    </td>
                </tr>
            </table>
            {{-- <table class="table table-striped table-bordered" id="table">
                @csrf
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>داخلی</th>
                        <th>نام</th>
                        <th>درصد پاسخ</th>
                        <th>مدت پاسخ</th>
                        <th>درصد بی پاسخ</th>
                        <th>مدت بی پاسخ</th>
                        <th>درصد مشغولی</th>
                        <th>تعداد کل</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="ext_row">
                        <td>
                            
                        </td>
                        <td>
                            <input type="text" name="ext[]" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="name[]" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="answer_percent[]" class="form-control">
                        </td>
                        <td>
                            <input type="text" min="0" max="60" name="answer_second[]" class="" style="width: 27%">:
                            <input type="text" min="0" max="60" name="answer_min[]" class="" style="width: 27%">:
                            <input type="text" min="0" max="24" name="answer_hour[]" class="" style="width: 27%">
                        </td>
                        <td>
                            <input type="text" name="unanswer_percent[]" class="form-control">
                        </td>
                        <td>
                            <input type="text" min="0" max="60" name="unanswer_second[]" class="" style="width: 27%">:
                            <input type="text" min="0" max="60" name="unanswer_min[]" class="" style="width: 27%">:
                            <input type="text" min="0" max="24" name="unanswer_hour[]" class="" style="width: 27%">
                        </td>
                        <td>
                            <input type="text" name="busy_percent[]" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="total[]" class="form-control">
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <button class="btn btn-info" id="add">+</button>
                        </td>
                        <td>
                            <button class="btn btn-success" id="submit">ثبت</button>
                        </td>
                    </tr>
                </tfoot>
                
            </table> --}}
            <button class="btn btn-success" id="submit">ثبت</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#date').persianDatepicker({
                altFormat: 'X',
                format: 'YYYY-MM-D',
                observer: true,
                timePicker: {
                    enabled: true
                },
            });
        });
        $('#add').on('click', function(){
            var tr    = $('.ext_row').html();
            $('#table').append("<tr>" + tr + "</tr>");
        });

        $('#submit').on('click', function(){
            var form = $('#form');
            var fd = $('#form').serialize();
            $.ajax({
                url: "{{url('admin/report/call')}}",
                data: fd,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (dataofconfirm) {
                    console.log(dataofconfirm);
                    if(dataofconfirm == 'done'){
                        $("#success").show().delay(3000).fadeOut();
                    }
                    else{
                        $("#error").show().delay(10000).fadeOut();
                        $('#error').html(dataofconfirm);
                    }
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        });
    </script>
@endsection