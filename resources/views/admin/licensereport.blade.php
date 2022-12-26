<?php

use App\CustomClasses\IssuesCatagory;

?>
@extends('layout.dashboard')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-6">
                    <form>
                        <lable>سال</lable>
                        <select name="year" id="year">
                            <option value="1397">97</option>
                            <option value="1398">98</option>
                        </select>
                    </form>
                    <button onclick="search()" id="button">search</button>
                    <script>
                        function search(){
                            var year = document.getElementById('year');
                            var Url = 'http://l.altfuel.ir/admin/report/license/' + year.value;
                            window.location.replace(Url);
                        }
                    </script>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    @foreach($numberOf as $numberof)
                        <tr>
                            <td>{{ $numberof['name'] }}</td>
                            <td>{{ $numberof['no'] }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection