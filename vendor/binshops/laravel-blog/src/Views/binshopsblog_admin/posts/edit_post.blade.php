@extends("layouts.app")
@section("content")


    <h5>Admin - Editing post
    <a target='_blank' href='{{$post->url()}}' class='float-right btn btn-primary'>View post</a>
    </h5>

    <form method='post' action='{{route("binshopsblog.admin.update_post",$post->id)}}'  enctype="multipart/form-data" >

        @csrf
        @method("patch")
        @include("binshopsblog_admin::posts.form", ['post' => $post])

        <input type='submit' class='btn btn-primary' value='Save Changes' >

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