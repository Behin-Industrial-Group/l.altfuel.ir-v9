@extends( 'layouts.app' )

@section( 'title' )
    ثبت درخواست جدید تخصیص بازرس
@endsection


@section( 'content' )
<p id="test"></p>
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    @if( isset( $message ) )
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                    @if( isset( $error ) )
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endif
                </div>
                <div class="box-body">
                    <div class="col-sm-10">
                        <tr>
                            <td>
                                نوع درخواست
                            </td>
                            <td>
                                <select class="form-control select2" id="request">
                                    <option></option>
                                    <option value="remove" id="remove_btn">حذف</option>
                                    <option value="asign" id="remove_btn">تخصیص</option>
                                </select>
                            </td>
                        </tr>
                        <table class="table table-bordered" id="asign_tbl"  style="display:none">
                            <form method="post" id="asign" action="{{ Url( 'admin/ins/asign/ins' ) }}">
                                @csrf
                                <input type="hidden" name="type" value="asign">
                                <tr>
                                    <td><p>ثبت تخصیص بازرس</p></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3>
                                            مشخصات بازرس
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        کدملی بازرس
                                    </td>
                                    <td>
                                        <input type="text" id="nationalId" name="nationalId" class="form-control" onkeyup="validateNID()" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        نام بازرس:
                                    </td>
                                    <td>
                                        <input type="text" name="fname" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        نام خانوادگی بازرس:
                                    </td>
                                    <td>
                                        <input type="text" name="lname" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        تلفن همراه:
                                    </td>
                                    <td>
                                        <input type="text" id="cellphone" name="cellphone" class="form-control" onkeyup="checkInputSize()" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ایمیل:
                                    </td>
                                    <td>
                                        <input type="text" name="email" class="form-control" required>
                                    </td>
                                </tr>


                                <tr>
                                    <td>
                                        <h3>
                                            مشخصات مرکز خدمات فنی
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        کد مرکز خدمات فنی:
                                    </td>
                                    <td>
                                        <input list="asign_markaz_code" name="codeEtehadie" id="codeEtehadie" required>
                                        <datalist id="asign_markaz_code"></datalist>
                                    </td>
                                </tr>
                                <tr>
                                        <td>
                                            توضیحات:
                                        </td>
                                        <td>
                                            <textarea type="text" name="ins_description" class="form-control"></textarea>
                                        </td>
                                    </tr>
                                <tr>
                                    <td>
                                        <input type="submit" id="submit"  class="btn btn-success" value="ارسال">
                                    </td>
                                </tr>
                            </form>
                        </table>



                        <table class="table table-bordered" id="remove_tbl" style="display:none">
                            <form id="remove" method="POST" action="{{ Url( 'admin/ins/asign/ins' ) }}">
                                @csrf
                                <input type="hidden" name="type" value="remove">
                                <tr>
                                    <td><p>حذف تخصیص بازرس</p></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3>
                                            مشخصات بازرس
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        کدملی بازرس
                                    </td>
                                    <td>
                                        <input list="nid" name="nationalId" id="remove_nationalId" class="form-control">
                                        <datalist id="nid"></datalist>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        نام بازرس:
                                    </td>
                                    <td>
                                        <input type="text" name="fname" id="remove_fname" class="form-control" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        نام خانوادگی بازرس:
                                    </td>
                                    <td>
                                        <input type="text" name="lname" id="remove_lname" class="form-control" readonly="readonly">
                                    </td>
                                </tr>


                                <tr>
                                    <td>
                                        <h3>
                                            مشخصات مرکز خدمات فنی
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        کد مرکز خدمات فنی:
                                    </td>
                                    <td>
                                        <input type="text" name="lname" id="remove_markaz_code" class="form-control" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                        <td>
                                            توضیحات:
                                        </td>
                                        <td>
                                            <textarea type="text" name="ins_description" class="form-control"></textarea>
                                        </td>
                                    </tr>
                                <tr>
                                    <td>
                                        <input type="submit" id="submit"  class="btn btn-success" value="ارسال">
                                    </td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateNID()
        {
            var code = document.getElementById("nationalId").value;
            var str = code.toString();

            // validate the string length and value
            var strLen = str.length, strVal = parseInt(str);
            if ( strLen < 8 || strLen > 10 || isNaN(strVal) || strVal == 0 )
            {
                document.getElementById("nationalId").style.border = "solid 2px red";
                document.getElementById("submit").style.display = "none";
            }

            // make sure the string is padded with zeros
            while ( str.length < 10 ) str = '0' + str;

            // invalidate consecutive arrangement of the same digit
            if ( str.match(/^(\d)\1+$/g) )
            {
                document.getElementById("nationalId").style.border = "solid 2px red";
                document.getElementById("submit").style.display = "none";
            }

            var checkDigit = parseInt(str.slice(-1)), // rightmost digit
                str = str.slice(0, -1); // remove the check digit

            for ( var sum = 0, i = str.length; i > 0; i-- )
                sum += (i+1) * str.substr( -i, 1 );

            // calculate sum modulo 11
            var mod = sum % 11;

            if (( mod < 2 && mod === checkDigit ) || ( mod >= 2 && mod + checkDigit === 11))
            {
                document.getElementById("nationalId").style.border = "solid 2px green";
                document.getElementById("submit").style.display = "block";
            }else
            {
                document.getElementById("nationalId").style.border = "solid 2px red";
                document.getElementById("submit").style.display = "none";
            }

        }

        function checkInputSize()
        {
            var input = document.getElementById("cellphone");

            // validate the string length and value
            var strLen = input.value.length;
            if ( strLen == 11 )
            {
                input.style.border = "solid 2px green";
                document.getElementById("submit").style.display = "block";
            }else
            {
                input.style.border = "solid 2px red";
                document.getElementById("submit").style.display = "none";
            }
        }

    </script>
@endsection

@section('script')
    <script>
    $('#request').on('click',function(){
        if ($(this).val() === 'remove') {
            $('#asign_tbl').css({ 'display': 'none' });
            $('#remove_tbl').css({ 'display': 'block' });
        }
        if($(this).val() === 'asign'){
            $('#asign_tbl').css({ 'display': 'block' });
            $('#remove_tbl').css({ 'display': 'none' });
        }

    });
    $("#remove_nationalId").on('keyup', function(){
        var nid = $("#remove_nationalId").val();
        $.get( "{{url('admin/ins/asign/get/nids')}}/"+ nid, function( data ) {
            $( "#nid" ).html( data );
        });

        var nid_length = $("#remove_nationalId").val().length;
        if(nid_length == 10){
            $.get("{{url('admin/ins/asign/get/ins_fname')}}/" + nid, function(data){
                $('#remove_fname').val(data);
            });
            $.get("{{url('admin/ins/asign/get/ins_lname')}}/" + nid, function(data){
                $('#remove_lname').val(data);
            });
            $.get("{{url('admin/ins/asign/get/markaz_code')}}/" + nid, function(data){
                $('#remove_markaz_code').val(data);
            });
        }
        $("#remove").ajaxForm(
            {url: "{{ Url( 'admin/ins/asign/ins' ) }}", type: 'post'}
        );
    });

    $('#codeEtehadie').on('keyup', function(){
        var markaz_code = $('#codeEtehadie').val();
        $.get("{{url('admin/marakez/get')}}/" + markaz_code, function(options){
            $('#asign_markaz_code').html(options);
        });
    });


    </script>
@endsection
