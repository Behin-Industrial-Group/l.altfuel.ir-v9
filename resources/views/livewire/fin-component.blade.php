
<div>
    <form class="form-horizontal" method="POST" action="javascript:void(0)" id="fin-form">
        @csrf
        <input type="hidden" class="form-control" id="" name="agency" value="{{ $agency['name'] }}">
        <input type="hidden" class="form-control" id="" name="agency_id" value="{{ $agency_info->id ?? ''}}">
        <table class="table table-striped table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>مبلغ</th>
                    <th>تاریخ واریز</th>
                    <th>کدپیگیری</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agency['payment'] as $item)
                    <tr>
                        <td>
                            {{__($item['fa_name'])}}
                            <input 
                                type="hidden"
                                class="form-control" 
                                name="{{$item['name']}}[name]" 
                                value="{{ $results->where('name', $item['name'])->first()->name ?? $item['name'] }}"
                                id=""
                                readonly>
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="{{$item['name']}}[price]" 
                                value="{{ $results->where('name', $item['name'])->first()->price ?? '' }}"
                                id="">
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="{{$item['name']}}[pay_date]" 
                                value="{{ $results->where('name', $item['name'])->first()->pay_date ?? '' }}"
                                id="">
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="{{$item['name']}}[ref_id]" 
                                value="{{ $results->where('name', $item['name'])->first()->ref_id ?? '' }}"
                                id="">
                        </td>
                    </tr>
                @endforeach
                @foreach ($agency['extra-payment'] as $item)
                    <tr>
                        <td>
                            <input 
                                type="text"
                                class="form-control" 
                                name="{{$item['name']}}[name]" 
                                value="{{ $results->where('name', $item['name'])->first()->name ?? $item['name'] }}"
                                id=""
                                readonly>
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="{{$item['name']}}[price]" 
                                value="{{ $results->where('name', $item['name'])->first()->price ?? '' }}"
                                id="">
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="{{$item['name']}}[pay_date]" 
                                value="{{ $results->where('name', $item['name'])->first()->pay_date ?? '' }}"
                                id="">
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="{{$item['name']}}[ref_id]" 
                                value="{{ $results->where('name', $item['name'])->first()->ref_id ?? '' }}"
                                id="">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="table table-striped table-bordered" style="width: 100%;">
            <tr>
                <td><label for="" class="control-label" style="color: red">مبلغ بدهی</label></td>
                <td colspan="3">
                    <input 
                    type="text" 
                    class="form-control price" 
                    id="" 
                    name="debt"
                    value="{{ $agency_info->debt }}">
                    <p class="cama-seprator" style="font-size:10px"></p>
                </td>
            </tr>
            <tr>
                <td><label for="" class="control-label" style="color: red">شرح بدهی</label></td>
                <td colspan="3">
                    <input 
                    type="text" 
                    class="form-control" 
                    id="" 
                    name="debt_description"
                    value="{{ $agency_info->debt_description }}">
                    <p class="cama-seprator" style="font-size:10px"></p>
                </td>
            </tr>
            <tr>
                <td><label for="" class="control-label" style="color: red">کدرهگیری پرداخت بدهی</label></td>
                <td colspan="3">
                    <input 
                    type="text" 
                    class="form-control" 
                    id="" 
                    name="" 
                    value="{{ $agency_info->debt_RefID }}"
                    disabled>
                    <p class="cama-seprator" style="font-size:10px"></p>
                </td>
            </tr>
        </table>

        <table class="table table-striped table-bordered" style="width: 100%;">
            <tr>
                <td><label for="" class="control-label">سبز</label></td>
                <td>
                    <input 
                    type="checkbox" 
                    class="" id="" 
                    name="FinGreen"
                    @if ($agency_info->FinGreen == 'ok')
                        {{ 'checked' }}
                    @endif>
                </td>
            </tr>
            <tr>
                <td><label for="" class="control-label">توضیحات مالی</label></td>
                <td colspan="3">
                    <textarea type="text" class="form-control" id="" name="FinDetails">{{ $agency_info->FinDetails }}</textarea>
                </td>
            </tr>
        </table>
    </form>
    <button class="btn btn-info" onclick="save_fin_info()">ذخیره اطلاعات مالی</button> 
</div>

<script>
    function save_fin_info(){
        send_ajax_request(
            "{{ route('fin-info.edit') }}",
            $('#fin-form').serialize(),
            function(data){
                console.log(data);
            },
            function(data){
                console.log(data);
                alert(data);
            }
        )
    }
</script>
