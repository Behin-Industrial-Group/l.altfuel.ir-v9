@extends( 'layouts.app' )

@section( 'title' )

@endsection


@section( 'content' )
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    افزودن دسته بندی ویدیو
                    @if( isset( $message ) )
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                </div>
                <div class="box-body">
                    <div class="col-sm-10">
                        <form method="post" action="{{ Url( 'admin/videos/addCatagory' ) }}">
                            @csrf
                            <div class="form-group">
                                <label>
                                    نام لاتین دسته بندی: 
                                </label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>
                                    نام فارسی دسته بندی: 
                                </label>
                                <input type="text" name="fa_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit"  class="btn btn-success" value="ثبت">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection