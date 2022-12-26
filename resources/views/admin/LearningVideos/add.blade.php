@extends( 'layouts.app' )

@section( 'title' )

@endsection


@section( 'content' )
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    افزودن ویدیو
                    @if( isset( $message ) )
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                </div>
                <div class="box-body">
                    <div class="col-sm-10">
                        <form method="post" action="{{ Url( 'admin/videos/add' ) }}">
                            @csrf
                            <div class="form-group">
                                <label>
                                    نام ویدیو
                                </label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>
                                    لینک ویدیو
                                </label>
                                <input type="text" name="link" class="form-control" dir="ltr" placeholder="http://">
                            </div>
                            <div class="form-group">
                                <label>
                                    دسته بندی:
                                </label>
                                <select class="col-sm-6 select2" name="catagory" dir="rtl">
                                    @foreach( $catagories as $catagory )
                                    <option value="{{ $catagory->name }}">{{ $catagory->fa_name }}</option>
                                    @endforeach
                                </select>
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