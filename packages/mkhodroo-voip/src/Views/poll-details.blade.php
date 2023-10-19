
<table class="table table-striped ">
    <thead>
        <tr>
            <th>شماره</th>
            <th>امتیاز</th>
            <th>تاریخ</th>
            {{-- <th>دانلود</th> --}}
        </tr>
    </thead>
    @foreach ($data as $item)
        <tr>
            <td>{{$item['src']}}</td>
            <td>{{$item['score']}}</td>
            <td dir="ltr">{{$item['calldate']}}</td>
            {{-- <td dir="ltr"><a href="https://voip.altfuel.ir/voice.php?date={{explode(" ",$item['calldate'])[0]}}&id={{$item['uniqueid']}}">دانلود</a></td> --}}
        </tr>
    @endforeach
</table>