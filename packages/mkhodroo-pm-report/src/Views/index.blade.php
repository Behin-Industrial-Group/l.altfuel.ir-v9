@extends('layouts.app')


@section('content')
    <div class="card p-4">
        <form action="{{ route('PMReport.index') }}" method="post" class="form col-sm-4">
            @csrf
            <table>
                <tr>
                    <td>
                        <select name="table_name" id="" class="form-control select2">
                            <option value="pmt_vacation_requests">{{ __('vacations') }}</option>
                            <option value="pmt_illegal_agencies">{{ __('illegal agencies') }}</option>
                            <option value="application">{{ __('application') }}</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-primary">{{ __('show') }}</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    
    <div class="card table-responsive p-4">
        <div class="col-sm-12">
            <i class="fa fa-filter btn btn-default" onclick="show_columns()"></i>
        </div>
        <div class="card p-4" style="display: none; text-align: left" id="columns" dir="ltr">
            @foreach ($colsName as $key => $col)
                {{ __($col) }}<input type="checkbox" name="name" onclick="columnVisible({{ $key }})" checked> | 
            @endforeach
        </div>
        <table class="table table-striped" id="pm-report-table">
            <thead>
                <tr>
                    @foreach ($colsName as $col)
                        <th>{{ __($col) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 0;
                @endphp
                @foreach ($results as $row)
                    <tr>
                        @for ($i = 0; $i < $numberOfCols; $i++)
                            @php
                                $field = $colsName[$i];
                            @endphp
                            <td>{{ $row->$field }}</td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
@endsection

@section('script')
<script>
    var table = $(`#pm-report-table`).DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            },
            className: 'btn btn-danger',
            attr: {
                style: 'direction: ltr'
            }
        }]
    })

    function columnVisible(num) {
        var column = table.column(num);

        column.visible(!column.visible());
    }
    function show_columns(){
        if($('#columns').css('display') == 'none'){
            $('#columns').css('display', 'block');
        }else{
            $('#columns').css('display', 'none')
        }
    }
</script>
@endsection
