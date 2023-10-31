@extends('layouts.app')

@section('style')
    <style>
        .select2{
            margin: 5px;
        }
    </style>
@endsection

@section('content')
    <form action="javascript:void(0)" id="get-help-support-form">
        <select name="main" id="main" class="select2" onchange="">
            <option value=""></option>
        </select>
    </form>
    <div id="answer"></div>

@endsection

@section('script')
    <script>
        initial_view()
        var main = $('#main');
        var select = $('.select');
        var form = $('#get-help-support-form')
        var fd = new FormData(form[0])
        send_ajax_formdata_request(
            "{{ route('helpSupport.get') }}",
            fd,
            function(res) {
                res.forEach(function(item) {
                    main.append(new Option(item.key, item.id))
                })
            }
        )
        main.on('change', function() {
            console.log($(this).val());
            get($(this).val())
        })

        function get(parent_id) {
            var fd = new FormData();
            fd.append('parent_id', parent_id)
            send_ajax_formdata_request(
                "{{ route('helpSupport.get') }}",
                fd,
                function(res) {
                    console.log(res);
                    create_new_select(parent_id, res)
                }
            )
        }

        function create_new_select(parent_id, res) {
            if (res[0].key == 'پاسخ') {
                var answer = $('#answer');
                answer.html(`<div>${res[0].key}: ${res[0].value}</div>`)
            } else {
                form.append(`<select id="p-${parent_id}" class="select2"><option></option>`)
                var sel = $(`#p-${parent_id}`)
                res.forEach(element => {
                    sel.append(new Option(element.key, element.id))
                });
                form.append('</select>')
                initial_view()
                sel.on('change', function() {
                    console.log($(this).val());
                    get($(this).val())
                })
            }

        }
    </script>
@endsection
