@extends('layouts.app')

@section('content')
    <div class="col-sm-12" style="height: 10px;"></div>
    <div class="card row" style="padding: 5px">
        <table class="table table-striped " id="draft-list">
            <thead>
                <tr>
                    <th>{{__('Id')}}</th>
                    <th>{{__('Number')}}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Process Name')}}</th>
                    <th style="text-align: center; direction: rtl">{{__('Status')}}</th>
                    <th style="text-align: center; direction: ltr">{{__('Send Date')}}</th>
                    <th style="text-align: center; direction: ltr">{{__('Delay')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $.get('{{ route("MkhodrooProcessMaker.api.draft") }}', function(r){
            console.log(r);
        })
        var table = create_datatable(
            'draft-list',
            '{{ route("MkhodrooProcessMaker.api.draft") }}',
            [
                {data : 'APP_UID', render: function(APP_UID){return APP_UID.substr(APP_UID.length - 8)}},
                {data : 'APP_NUMBER'},
                {data : 'DEL_TITLE'},
                {data : 'PRO_TITLE'},
                {data : 'TAS_STATUS'},
                {data : 'DEL_DELEGATE_DATE', render: function(DEL_DELEGATE_DATE){ return `<span style="float: left; direction: ltr">${DEL_DELEGATE_DATE}</span>`; }},
                {data : 'DELAY' , render: function(DELAY){ return `<span style="float: left; direction: ltr">${DELAY}</span>`; }},
                {data : 'APP_UID', render: function(APP_UID){return  `<i class='fa fa-trash bg-red' onclick="delete_case('${APP_UID}')"></i>`; }},
            ]
        );
        table.on('dblclick', 'tr', function(){
            var data = table.row( this ).data();
            console.log(data);
            var fd = new FormData();
            fd.append('processTitle', data.PRO_TITLE);
            fd.append('taskId', data.TAS_UID);
            fd.append('caseId', data.APP_UID);
            fd.append('caseTitle', data.DEL_TITLE);
            fd.append('processId', data.PRO_UID);
            fd.append('delIndex', data.DEL_INDEX);
            url = "{{ route('MkhodrooProcessMaker.api.getCaseDynaForm') }}";
            console.log(url);
            send_ajax_formdata_request(
                url,
                fd,
                function(response){
                    // console.log(response);
                    open_admin_modal_with_data(response)
                }
            )
        })

        function delete_case(caseId){
            url = "{{ route('MkhodrooProcessMaker.api.deleteCase', [ 'caseId' => 'caseId' ]) }}";
            url = url.replace('caseId', caseId)
            console.log(url);
            send_ajax_get_request_with_confirm(
                url,
                function(response){
                    console.log(response);
                },
                '{{__("Are You Sure For Delete This Item?")}}'
            )
        }
    </script>
@endsection