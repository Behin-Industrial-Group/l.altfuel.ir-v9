<table class="table table-striped ">
    <thead>
        <tr>
            <th>شماره</th>
            <th>امتیاز</th>
            <th>تاریخ</th>
        </tr>
    </thead>
    @foreach ($data as $item)
        <tr>
            <td>{{$item['src']}}</td>
            <td>{{$item['score']}}</td>
            <td dir="ltr">{{$item['calldate']}}</td>
        </tr>
    @endforeach
</table>