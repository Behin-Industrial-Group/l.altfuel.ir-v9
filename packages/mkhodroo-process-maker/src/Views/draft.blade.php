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
                    <th>{{__('Status')}}</th>
                    <th>{{__('Send Date')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script>
        // $.get('{{ route("MkhodrooProcessMaker.api.draft") }}', function(r){
        //     console.log(r);
        // })
        var table = create_datatable(
            'draft-list',
            '{{ route("MkhodrooProcessMaker.api.draft") }}',
            [
                {data : 'guid', render: function(guid){return guid.substr(guid.length - 8)}},
                {data : 'info', render: function(info){return info.caseNumber}},
                {data : 'name'},
                {data : 'info', render: function(info){return info.processName;}},
                {data : 'status', render: function(status){return `{{__('${status}')}}`}},
                {data : 'info', render: function(info){return info.updateDate}},
                {data : 'guid', render: function(guid){return  `<i class='fa fa-trash bg-red' onclick="delete_case('${guid}')"></i>`; }},
            ]
        );
        table.on('dblclick', 'tr', function(){
            var data = table.row( this ).data();
            console.log(data);
            var fd = new FormData();
            fd.append('processTitle', data.info.processName);
            fd.append('taskId', data.info.currentUsers.taskId);
            fd.append('caseId', data.guid);
            fd.append('caseTitle', data.name);
            fd.append('processId', data.info.processId);
            fd.append('delIndex', data.delIndex);
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