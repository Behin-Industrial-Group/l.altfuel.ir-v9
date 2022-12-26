@extends('layouts.app')

@section('title')
    
@endsection

@section('content')
    <div class="box ">
        <form action="javascript:void(0)" id="add-class-form">
            <table class="table table-stripped">
                <tr>
                    <td>عنوان دوره آموزشی</td>
                    <td><input type="text" name="title" id="" class="form-control"></td>
                </tr>
                <tr>
                    <td>روز</td>
                    <td>
                        <select name="day" id="" class="form-control">
                            <option value="2">پنج شنبه دوم تیرماه</option>
                            <option value="3">جمعه سوم تیرماه</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>ساعت شروع</td>
                    <td>
                        <input type="text" name="time" id="" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>ساعت پایان</td>
                    <td>
                        <input type="text" name="end_time" id="" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>متولی</td>
                    <td>
                        <input type="text" name="motevali" id="" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>مدرس</td>
                    <td>
                        <input type="text" name="teacher" id="" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>ظرفیت کلاس</td>
                    <td>
                        <input type="text" name="capacity" id="" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td><button class="btn btn-info" onclick="register()">ثبت <i class="fa fa-spinner fa-spin"></i></button></td>
                </tr>
            </table>
        </form>

        <script>
            hide_loading();
            function hide_loading(){
                $('.fa-spinner').hide()
            }
            function show_loading(){
                $('.fa-spinner').show()
            }

            function register(){
                show_loading();
                var form = document.querySelector("#add-class-form");
                var formData = new FormData(form);
                formData.append('_token','{{csrf_token()}}');
                
                $.ajax({
                    type: 'post',
                    url: '{{ route("add-class") }}',
                    processData: false,
                    contentType: false,
                    data:  formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data){
                        alert(data);
                        console.log(data);
                        hide_loading();
                    },
                    error:function(data){
                        alert(data.responseJSON.message);
                        console.log(data);
                        hide_loading();
                    }
                })
            }
        </script>
    </div>

    <div class="box">
        <table class="table table-stripped">
            @foreach ($classes as $c)
                <tr onclick="show_edit({{$c->id}})">
                    <td>{{ $c->code }}</td>
                    <td>{{ $c->title }}</td>
                    <td>{{ $c->day }}</td>
                    <td>{{ $c->time }}</td>
                    <td>{{ $c->end_time }}</td>
                    <td>{{ $c->motevali }}</td>
                    <td>{{ $c->teacher }}</td>
                    <td>{{ $c->capacity }}</td>
                </tr>
            @endforeach
        </table>
        @include('admin.hamayesh.edit-modal')
        <script>
            function show_edit(id) {  
                $('#modal-edit').modal('show');
                $.get(`{{ url('admin/hamayesh/edit-class') }}/${id}`, function(data){
                    console.log(data);
                    $('input[name="id"]').val(data.id)
                    $('input[name="code"]').val(data.code)
                    $('input[name="title"]').val(data.title)
                    $('input[name="day"]').val(data.day)
                    $('input[name="time"]').val(data.time)
                    $('input[name="end_time"]').val(data.end_time)
                    $('input[name="motevali"]').val(data.motevali)
                    $('input[name="teacher"]').val(data.teacher)
                    $('input[name="capacity"]').val(data.capacity)
                })
            }
        </script>
    </div>
@endsection