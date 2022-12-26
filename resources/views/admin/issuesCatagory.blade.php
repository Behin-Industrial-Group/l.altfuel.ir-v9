@extends('layouts.app')

@section('title')
    افزودن دسته بندی تیکت
@endsection

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-heading">
                <button class="btn btn-info" id="show-add-modal">افزودن</button>
            </div>
            
            <div class="box-body">
                <div class="">
                    <table class="table">
                        <tr>
                            <th>شناسه</th>
                            <th>نام</th>
                            <th>نام فارسی</th>
                            <th>ویرایش</th>
                        </tr>
                        @foreach( $catagories as $catagory )
                            <tr>
                                <th>{{$catagory->id}}</th>
                                <th>{{$catagory->name}}</th>
                                <th>{{$catagory->fa_name}}</th>
                                <th><a href=""><i class="fa fa-edit"></i></a></th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>افزودن دسته بندی جدید</h3>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tr>
                            <td>
                                <input type="text" name="name" id="name" class="form-control" placeholder="نام به انگلیسی">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="fa_name" id="fa_name" class="form-control" placeholder="نام به فارسی">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select name="catagory" id="catagory" class="form-control">
                                    <option value="License">پروانه کسب</option>
                                    <option value="irngv">irngv</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-success form-control" id="add">ثبت</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#show-add-modal').click(function(){
            $('#add-modal').modal('show')
        })

        $('#add').click(function(){
            var fd = {
                'name': $('#name').val(),
                'fa_name': $('#fa_name').val(),
                'catagory': $('#catagory').val()
            }

            console.log(fd);
            $.ajax({
                type: 'get',
                url: '{{url('admin/issues/add-catagory')}}',
                data:  fd,
                success:function(data){
                    alert(data);
                    location.reload();
                },
                error:function(){
                    alert('خطا در سرور')
                }
            })
        })
    </script>
@endsection