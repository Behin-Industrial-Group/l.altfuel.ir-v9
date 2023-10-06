@extends('PMViews::dyna-form-layout')
@section('content')
    <form action="javascript:void(0)" id="main-form">

        <div class="row form-group">
            <div class="col-sm-3">{{ __('name') }}</div>
            <div class="col-sm-9">
                <input type="text" name="name" value="{{ $vars->name ?? '' }}" class="form-control" id="">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">{{ __('type') }}</div>
            <div class="col-sm-9">
                <input type="text" name="type" value="{{ $vars->type ?? '' }}" class="form-control" id="">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">{{ __('duration') }}</div>
            <div class="col-sm-9">
                <input type="text" name="duration" value="{{ $vars->duration ?? '' }}" class="form-control"
                    id="">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">{{ __('startDate') }}</div>
            <div class="col-sm-9">
                <input type="text" name="startDate" value="{{ $vars->startDate ?? '' }}" class="form-control"
                    id="">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">{{ __('endDate') }}</div>
            <div class="col-sm-9">
                <input type="text" name="endDate" value="{{ $vars->endDate ?? '' }}" class="form-control" id="">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">{{ __('substitute') }}</div>
            <div class="col-sm-9">
                <input type="text" name="substitute" value="{{ $vars->substitute ?? '' }}" class="form-control"
                    id="">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">{{ __('emergencyPhone') }}</div>
            <div class="col-sm-9">
                <input type="text" name="emergencyPhone" value="{{ $vars->emergencyPhone ?? '' }}" class="form-control"
                    id="">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">{{ __('description') }}</div>
            <div class="col-sm-9">
                <input type="text" name="description" value="{{ $vars->description ?? '' }}" class="form-control"
                    id="">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">{{ __('departmentManagerName') }}</div>
            <div class="col-sm-9">
                <input type="text" name="departmentManagerName" value="{{ $vars->departmentManagerName ?? '' }}"
                    class="form-control" id="">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">{{ __('departmentManagerResult') }}</div>
            <div class="col-sm-9">
                <select name="departmentManagerResult" class="form-control" id="">
                    <option value="1"
                        {{ isset($vars->departmentManagerResult) && $vars->departmentManagerResult == '1' ? 'selected' : '' }}>
                        {{ __('approved') }}</option>
                    <option value="0"
                        {{ isset($vars->departmentManagerResult) && $vars->departmentManagerResult == '0' ? 'selected' : '' }}>
                        {{ __('declined') }}</option>
                </select>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">{{ __('bossResult') }}</div>
            <div class="col-sm-9">
                <input type="text" name="bossResult" value="{{ $vars->bossResult ?? '' }}" class="form-control"
                    id="">
            </div>
        </div>

        <div class="row form-group">
            <button class="btn btn-primary m-1"
                    onclick="save_and_next()">{{ __('save and next') }}</button>
            
            <button class="btn btn-default m-1" onclick="save()">{{ __('save') }}</button>
        </div>

    </form>
    <script>
        function save_and_next() {
            var fd = new FormData($("#main-form")[0]);
            fd.append('caseId', '{{ $caseId }}')
            // fd.append('del_index', '')
            // fd.append('task', '')
            // fd.append('user_logged', '')

            send_ajax_formdata_request(
                "{{ route('MkhodrooProcessMaker.api.saveAndNext') }}",
                fd,
                function(response) {
                    console.log(response);
                }
            )
        }

        function save() {
            var fd = new FormData($("#main-form")[0]);
            fd.append('caseId', '{{ $caseId }}')
            // fd.append('del_index', '')
            // fd.append('task', '')
            // fd.append('user_logged', '')

            send_ajax_formdata_request(
                "{{ route('MkhodrooProcessMaker.api.save') }}",
                fd,
                function(response) {
                    console.log(response);
                }
            )
        }
    </script>
@endsection
