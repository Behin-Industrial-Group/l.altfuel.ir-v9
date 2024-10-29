@extends('layouts.app')

@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ trans('id') }}</th>
                    <th>{{ trans('fullname') }}</th>
                    <th>{{ trans('national id') }}</th>
                    <th>{{ trans('business name') }}</th>
                    <th>{{ trans('manager name') }}</th>
                    <th>{{ trans('state') }}</th>
                    <th>{{ trans('city') }}</th>
                    <th>{{ trans('center type') }}</th>
                    <th>{{ trans('complaint subject') }}</th>
                    <th>{{ trans('visit date') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($complaints as $complaint)
                    @php
                        $complaint_content = json_decode($complaint->content);
                    @endphp
                    <tr>
                        <td>{{ $complaint->id }}</td>
                        <td>{{ $complaint_content->first_name_last_name }}</td>
                        <td>{{ $complaint_content->national_code }}</td>
                        <td>{{ $complaint_content->business_name }}</td>
                        <td>{{ $complaint_content->manager_name }}</td>
                        <td>{{ $complaint_content->state }}</td>
                        <td>{{ $complaint_content->city }}</td>
                        <td>{{ $complaint_content->center_type }}</td>
                        <td>{{ $complaint_content->complaint_subject }}</td>
                        <td>{{ $complaint_content->visit_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
