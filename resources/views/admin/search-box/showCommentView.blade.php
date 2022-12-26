@extends('layout.dashboard')

<?php
use Illuminate\Support\Facades\DB;
?>


@section('title')

@endsection

@section('content')
    <div class='row'>
        <div class="box">
            <div class="box-header">
                
            </div>
            <div class="box-body">
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($results as $result)
                    <tr>
                        <?php
                        $issue = DB::table($result->table_name)->where('id', $result->record_id)->first();
                        $issue_url = Url("/admin/issues/$issue->catagory/$issue->NationalID#issue_$issue->id");
                        ?>
                        <td>{{ $result->table_name }}</td>
                        <td>
                            <a href="{{ $issue_url }}">
                                {{ $result->record_id }}
                            </a>
                        </td>
                        <td>{{ $result->comment }}</td>
                        <td>{{ $result->updated_at }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection