@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="card p-4">
            <button onclick="new_agency()" class="btn btn-primary col-sm-2">{{ __('Add New Agency') }}</button>
        </div>

        <div class="card p-4 ">
            <form action="javascript:void(0)" id="filter-form1" class="col-sm-12 table-responsive">
                <table class="table table-striped table-responsive ">
                    <td>{{ __(config('agency_info.main_field_name')) }}</td>
                    <td>
                        <select name="{{ config('agency_info.main_field_name') }}" id="" class="form-control">
                            <option value="">{{ __('All') }}</option>
                            @foreach (config('agency_info.customer_type') as $catagory => $catagory_detail)
                                <option value="{{ $catagory }}">{{ __($catagory_detail['name']) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>استان</td>
                    <td>
                        <select name="province" id="" class="form-control">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="field_value" id="" class="form-control"
                            placeholder="{{ __('Everything') }}">
                    </td>
                    <td>
                        <button onclick="filter()" class="btn btn-primary">{{ __('Filter') }}</button>
                    </td>
                    <td>
                        <button class="btn btn-default" onclick="show_columns()">{{ __('Columns') }}</button>
                    </td>
                </table>
            </form>

        </div>
        <div class="card p-4" style="display: none" id="columns_div">
            <div class="row">
                <div class="col-sm-12" style="float: right">
                    <select name="columns" id="columns" class="select2" multiple>
                        @for ($i = 0; $i < count($cols); $i++)
                            <option value="{{ $i }}">{{ __($cols[$i]) }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="card p-4">

            <table class="table table-stripped" id="infos">
                <thead>
                    <tr>
                        @for ($i = 0; $i < count($cols); $i++)
                            <th>{{ __($cols[$i]) }}</th>
                        @endfor
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        initial_view()
        send_ajax_get_request(
            "{{ route('agencyInfo.list') }}",
            function(res) {
                console.log(res);
            }
        )
        $(document).ready(function() {
            var table = create_datatable(
                "infos",
                "{{ route('agencyInfo.list') }}",
                [
                    @for ($i = 0; $i < count($cols); $i++)
                        {
                            data: '{{ $cols[$i] }}',
                            render: function(data) {
                                return data ? data : '';
                            },
                            visible: <?php echo in_array($cols[$i], config('agency_info.default_fields')) ? true : 'false'; ?>
                        }
                        @if ($i != count($cols) - 1)
                            ,
                        @endif
                    @endfor
                ],
                function(row, data) {
                    // تغییر رنگ پس‌زمینه ردیف بر اساس مقدار فیلد enable
                    if (data.fin_green == 'ok') {
                        $(row).css('background-color', 'green');
                    }
                }
            )

            table.on('dblclick', 'tr', function() {
                var data = table.row(this).data();
                console.log(data);
                open_edit_form(data.parent_id, 'info')
                // show_edit_modal(data.id);
            })
        })


        function columnVisible(num) {
            var column = table.column(num);
            column.visible(1);
        }

        function columnHide(num) {
            var column = table.column(num);
            column.visible(0);
        }

        $('#columns').val([
            @for ($i = 0; $i < count($cols); $i++)
                @if (in_array($cols[$i], config('agency_info.default_fields')))
                    "{{ $i }}",
                @endif
            @endfor
        ]).trigger("change");

        function apply() {
            @for ($i = 0; $i < count($cols); $i++)
                columnHide({{ $i }})
            @endfor
            var columns = $('#columns').val();
            columns.forEach(function(column) {
                columnVisible(column)
            })
        }

        function show_columns() {
            var c = $('#columns_div')
            if (c.css('display') == 'none') {
                c.css('display', 'block')
            } else {
                c.css('display', 'none')
            }
        }

        function open_edit_form(parent_id, active_tab) {
            url = "{{ route('agencyInfo.editForm', ['parent_id' => 'parent_id']) }}";
            url = url.replace('parent_id', parent_id);
            open_admin_modal(
                url,
                '',
                function() {
                    var tab = $(`#${active_tab}-tab`).attr('class');
                    var tabBody = $(`#${active_tab}`).attr('class');
                    $(`#${active_tab}-tab`).click()
                }
            )

        }

        function new_agency() {
            open_admin_modal(
                "{{ route('agencyInfo.createForm') }}"
            )
        }

        function filter() {
            apply()
            var fd = new FormData($('#filter-form1')[0]);
            fd.append('cols', $('#columns').val());
            send_ajax_formdata_request(
                "{{ route('agencyInfo.filterList') }}",
                fd,
                function(res) {
                    // console.log(res);
                    update_datatable(res.data);
                }
            )
        }
    </script>
@endsection
