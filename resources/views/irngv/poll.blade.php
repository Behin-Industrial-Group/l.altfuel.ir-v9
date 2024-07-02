@extends('layout.welcome_layout')



@section('title')
    نظرسنجی
@endsection

@section('content')
    <div class="row">
        <div class="box table-responsive" id="main">
            @if (count($poll_info))
                <div class="alert alert-info">
                    شما قبلا در این نظرسنجی شرکت کرده اید
                </div>
            @else
                <div class="col-sm-12" style="margin: 15px; background: gray; font-weight: bold; padding: 5px; color: white ">
                    <div class="">
                        نام و نام خانودگی: {{ $info->owner_fullname }}
                    </div>
                    <div>
                        خودرو: {{ $info->car_name }}
                    </div>
                    <div>
                        شاسی: {{ $info->chassis }}
                    </div>
                </div>
                <form action="javascript:void(0)" id="poll-form">
                    <input type="hidden" name="link" id="" value="{{ $info->link }}">
                    <table class="table table-striped" style="margin: 15px">
                        <tr>
                            <td colspan="6">جهت مشاهده گزینه های هر سوال صفحه را به چپ یا راست بکشید</td>
                        </tr>
                        @foreach ($questions as $key => $value)
                            @if ($value['enable'] === 1)
                                @if ($value['reg_type'] == $info->reg_type)
                                    <tr>
                                        <td>{{ $value['question'] }}</td>
                                        @foreach ($value['answers'] as $a_key => $a_value)
                                            <td><input type="radio" name="{{ $key }}" id="{{ $key }}"
                                                    value="{{ $a_key }}">{{ $a_value }}</td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endif
                        @endforeach

                        <tfoot>
                            <tr>
                                <td>
                                    <button class="col-sm-12 btn btn-success" onclick="register_answer()">ثبت</button>
                                </td>
                            </tr>
                            <tr>
                                <td>پشتیبانی: 02191013791 و 02191012961</td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            @endif
        </div>
    </div>
    <script>
        function register_answer() {
            var v = validation();
            if (v) {
                alert(v);
                return false;
            }
            $.ajax({
                url: `{{ route('register-poll-answers') }}`,
                data: $('#poll-form').serialize(),
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'post',
                success: function(data) {
                    $('#main').html(
                        "<div class='alert alert-success'>اطلاعات با موفیت ذخیره شد. با تشکر از مشارکت شما</div>"
                        );
                },
                error: function(er) {
                    console.log(er);
                    alert("خطایی هنگام ذخیره اطلاعات رخ داد. با پشتیبانی تماس بگیرید.");
                }
            })
        }

        function validation() {
            @foreach ($questions as $key => $value)
                @if ($value['enable'] === 1)
                    if (!$('input[name="{{ $key }}"]:checked').val()) {
                        return `پاسخی برای سوال: {{ $value['question'] }} ثبت نشده است`;
                    }
                @endif
            @endforeach
            return false;
        }
    </script>
@endsection
