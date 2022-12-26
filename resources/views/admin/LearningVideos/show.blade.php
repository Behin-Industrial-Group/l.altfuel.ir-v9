@extends( 'layouts.app' )

@section( 'title' )

@endsection


@section( 'content' )
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    نمایش ویدیو
                    @if( isset( $message ) )
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table" id="table">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>نام ویدیو</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>تاریخ آپدیت</th>
                                </tr>
                            </thead>
                            <?php $i=1; ?>
                            @foreach( $videos as $video )
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td><a href="{{ $video->link }}">{{ $video->name }}</a></td>
                                    <td>{{ $video->created_at }}</td>
                                    <td>{{ $video->updated_at }}</td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection