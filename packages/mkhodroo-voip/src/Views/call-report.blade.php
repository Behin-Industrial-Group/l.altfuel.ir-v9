<table class="table table-striped ">
    <thead>
        <tr>
            <th>شماره</th>
            <th>مقصد</th>
            <th>وضعیت</th>
            <th>تاریخ</th>
            <th>مدت مکالمه</th>
            <th>دانلود</th>
        </tr>
    </thead>
    @if (is_array($data))
    @foreach ($data as $item)
    <tr>
        <td>{{ $item['src'] }}</td>
        <td>{{ $item['dst'] }}</td>
        <td>{{ __($item['disposition']) }}</td>
        <td dir="ltr">{{ $item['calldate'] }}</td>
        <td dir="ltr">{{ $item['duration'] }}</td>
        <td dir="ltr">
            <p
                style="cursor: pointer"
                onclick="dl(`https://voip.altfuel.ir/voice.php?date={{ explode(' ', $item['calldate'])[0] }}&id={{ $item['uniqueid'] }}`)">
                دانلود
            </p>
        </td>
    </tr>
@endforeach
    @endif
    
</table>
<script>
    function dl(link) {
        var fd = new FormData();
        fd.append('link', link)
        send_ajax_formdata_request(
            "{{ route('voip.dlVoice') }}",
            fd,
            function(res) {
                if (res == "404") {
                    show_error("فایل وجود ندارد");
                } else {
                    var link = document.createElement("a");
                    link.setAttribute('download', name);
                    link.href = res;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                }
            }
        )
    }
</script>
