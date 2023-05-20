@extends("layouts.app")
@section("content")


    <h5>Admin - Add post</h5>

    <form method='post' action='{{route("binshopsblog.admin.store_post")}}'  enctype="multipart/form-data" >

        @csrf
        @include("binshopsblog_admin::posts.form", ['post' => new \BinshopsBlog\Models\BinshopsBlogPost()])

        <input type='submit' class='btn btn-primary' value='Add new post' >

    </form>
    @if( config("binshopsblog.use_wysiwyg") && config("binshopsblog.echo_html") && (in_array( \Request::route()->getName() ,[ 'binshopsblog.admin.create_post' , 'binshopsblog.admin.edit_post'  ])))
        <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
        <script>
            if( typeof(CKEDITOR) !== "undefined" ) {
                CKEDITOR.replace('post_body');
            }
        </script>
    @endif

@endsection
