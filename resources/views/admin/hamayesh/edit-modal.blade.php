<?php 
use App\CustomClasses\Access;
?>

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">
              ویرایش اطلاعات  
              مرکز: <span id="markaz-fullname"></span>
              کد: <span id="markaz-code"></span>
            </h4>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0)" id="edit-class-form">
                <input type="hidden" name="id" id="">
                <table class="table table-stripped">
                    <tr>
                        <td>کد دوره آموزشی</td>
                        <td><input type="text" name="code" id="" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>عنوان دوره آموزشی</td>
                        <td><input type="text" name="title" id="" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>روز</td>
                        <td>
                            <input type="text" name="day" id="" class="form-control">
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
                        <td><button class="btn btn-info" onclick="edit()">ثبت <i class="fa fa-spinner fa-spin"></i></button></td>
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
    
                function edit(){
                    show_loading();
                    var form = document.querySelector("#edit-class-form");
                    var formData = new FormData(form);
                    formData.append('_token','{{csrf_token()}}');
                    
                    $.ajax({
                        type: 'post',
                        url: '{{ route("edit-class") }}',
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
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">خروج</button>
        </div>
      </div>
    </div>
</div>
