@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
       
        <section class="content">
          <form action="javascript:void(0)">
            @csrf
            <div class="col-sm-3">
              حداکثر حجم آپلود فایل: 
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control col-sm-9" name="max_upload_file_size" id="" value="{{ $max_upload_file_size }}">
              کیلوبایت
            </div>
            <button class="btn btn-success" id="submit">ثبت</button>
          </form>
          <script>
            $('#submit').click(function(){
              var formData = $('form').serialize();
              $.ajax({
                type: 'post',
                url: '{{url('admin/options')}}',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data == 200){
                        alert('تغییرات ذخیره شد')
                    }else{
                        alert(data);
                    }
                },
                error: function(){
                    alert('server error')
                }
            })
            })
          </script>
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      
@endsection