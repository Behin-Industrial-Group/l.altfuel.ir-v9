@extends('layouts.app')

@section('title')
    گزارش نظرسنجی irngv
@endsection

@section('content')
    <div class="panel" style="padding: 3px">
        <button class="btn btn-default" onclick="show_filters()" data-toggle="tooltip" title="نمایش فیلترها">
            <i class="fa fa-filter" aria-hidden="true"></i>
        </button>
    </div>
    <div class="row" id="filters" style="display: none">
        <div class="box">
            @livewire('filter-component', ['model' => new \App\Models\IrngvPollAnswer])
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>سوال</th>
                <th>میانگین جواب ها</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $key => $value)
                <tr>
                    <td>{{ $questions[$key]['question'] }}</td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>سوال</th>
                <th>خیلی کم</th>
                <th>کم</th>
                <th>متوسط</th>
                <th>زیاد</th>
                <th>خیلی زیاد</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($number_report as $key => $value)
                @if ($key != "q5")
                    <tr>
                        <td>{{ $questions[$key]['question'] }}</td>
                        <td>{{ $value[1] ?? '' }}</td>
                        <td>{{ $value[2] ?? ''}}</td>
                        <td>{{ $value[3] ?? ''}}</td>
                        <td>{{ $value[4] ?? ''}}</td>
                        <td>{{ $value[5] ?? ''}}</td>
                    </tr>
                @endif
                @if ($key === "q5")
                    <tr>
                        <th>سوال</th>
                        <th>بله</th>
                        <th>خیر</th>
                    </tr>
                    <tr>
                        <td>{{ $questions[$key]['question'] }}</td>
                        <td>{{ $value[1] ?? '' }}</td>
                        <td>{{ $value[2] ?? ''}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        function show_filters(){
            if ($("#filters").css("display") == "none") {
                $('#filters').fadeIn(500);
            } else {
                $('#filters').fadeOut(500);
            }
            
        }
        function filter(){
            send_ajax_request(
                "{{ route('report.irngv.poll.get')}}",
                $('#filter-form').serialize(),
                function(data){
                    console.log(data);
                }
            );
        }
        
    </script>
@endsection