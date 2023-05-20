@extends("layouts.app")

@section("content")

<ul class="list-group">
    <li class="list-group-item list-group-color justify-content-between lh-condensed">
        <div>
            <h6 class="my-0"><a href="{{ route('binshopsblog.admin.index') }}">Dashboard</a>
                <span class="text-muted">(<?php
                    $categoryCount = \BinshopsBlog\Models\BinshopsBlogPost::count();

                    echo $categoryCount . " " . str_plural("Post", $categoryCount);

                    ?>)</span>
            </h6>
            <small class="text-muted">Overview of your posts</small>

            <div class="list-group ">

                <a href='{{ route('binshopsblog.admin.index') }}'
                   class='list-group-item list-group-color list-group-item list-group-color-action @if(\Request::route()->getName() === 'binshopsblog.admin.index') active @endif  '><i
                            class="fa fa-th fa-fw"
                            aria-hidden="true"></i>
                    All Posts</a>
                <a href='{{ route('binshopsblog.admin.create_post') }}'
                   class='list-group-item list-group-color list-group-item list-group-color-action  @if(\Request::route()->getName() === 'binshopsblog.admin.create_post') active @endif  '><i
                            class="fa fa-plus fa-fw" aria-hidden="true"></i>
                    Add Post</a>
            </div>
        </div>
    </li>


    <li class="list-group-item list-group-color justify-content-between lh-condensed">
        <div>
            <h6 class="my-0"><a href="{{ route('binshopsblog.admin.comments.index') }}">Comments</a>

                <span class="text-muted">(<?php
                    $commentCount = \BinshopsBlog\Models\BinshopsBlogComment::withoutGlobalScopes()->count();

                    echo $commentCount . " " . str_plural("Comment", $commentCount);

                    ?>)</span>
            </h6>
            <small class="text-muted">Manage your comments</small>

            <div class="list-group ">
                <a href='{{ route('binshopsblog.admin.comments.index') }}'
                   class='list-group-item list-group-color list-group-item list-group-color-action  @if(\Request::route()->getName() === 'binshopsblog.admin.comments.index' && !\Request::get("waiting_for_approval")) active @endif   '><i
                            class="fa  fa-fw fa-comments" aria-hidden="true"></i>
                    All Comments</a>


                <?php $comment_approval_count = \BinshopsBlog\Models\BinshopsBlogComment::withoutGlobalScopes()->where("approved", false)->count(); ?>

                <a href='{{ route('binshopsblog.admin.comments.index') }}?waiting_for_approval=true'
                   class='list-group-item list-group-color list-group-item list-group-color-action  @if(\Request::route()->getName() === 'binshopsblog.admin.comments.index' && \Request::get("waiting_for_approval")) active @elseif($comment_approval_count>0) list-group-item list-group-color-warning @endif  '><i
                            class="fa  fa-fw fa-comments" aria-hidden="true"></i>
                    {{ $comment_approval_count }}
                    Waiting for approval </a>

            </div>
        </div>
    </li>


    <li class="list-group-item list-group-color  justify-content-between lh-condensed">
        <div>
            <h6 class="my-0"><a href="{{ route('binshopsblog.admin.categories.index') }}">Categories</a>
                <span class="text-muted">(<?php
                    $postCount = \BinshopsBlog\Models\BinshopsBlogCategory::count();
                    echo $postCount . " " . str_plural("Category", $postCount);
                    ?>)</span>
            </h6>


            <small class="text-muted">Blog post categories</small>

            <div class="list-group ">
                <a href='{{ route('binshopsblog.admin.categories.index') }}'
                   class='list-group-item list-group-color list-group-item list-group-color-action  @if(\Request::route()->getName() === 'binshopsblog.admin.categories.index') active @endif  '><i
                            class="fa fa-object-group fa-fw" aria-hidden="true"></i>
                    All Categories</a>
                <a href='{{ route('binshopsblog.admin.categories.create_category') }}'
                   class='list-group-item list-group-color list-group-item list-group-color-action  @if(\Request::route()->getName() === 'binshopsblog.admin.categories.create_category') active @endif  '><i
                            class="fa fa-plus fa-fw" aria-hidden="true"></i>
                    Add Category</a>
            </div>
        </div>

    </li>

    @if(config("binshopsblog.image_upload_enabled"))
        <li class="list-group-item list-group-color  justify-content-between lh-condensed">
            <div>
                <h6 class="my-0"><a href="{{ route('binshopsblog.admin.images.upload') }}">Upload images</a></h6>

                <div class="list-group ">

                    <a href='{{ route('binshopsblog.admin.images.all') }}'
                       class='list-group-item list-group-color list-group-item list-group-color-action  @if(\Request::route()->getName() === 'binshopsblog.admin.images.all') active @endif  '><i
                                class="fa fa-picture-o fa-fw" aria-hidden="true"></i>
                        View All</a>

                    <a href='{{ route('binshopsblog.admin.images.upload') }}'
                       class='list-group-item list-group-color list-group-item list-group-color-action  @if(\Request::route()->getName() === 'binshopsblog.admin.images.upload') active @endif  '><i
                                class="fa fa-upload fa-fw" aria-hidden="true"></i>
                        Upload</a>
                </div>
            </div>
        </li>
    @endif
</ul>

    @if(count($posts) > 0)
        <div class='search-form-outer mb-3'>
            <form method='get' action='{{route("binshopsblog.admin.searchblog", app('request')->get('locale'))}}' class='text-center'>
                <input style="display: inline-block; width: 50%" type='text' name='s' placeholder='Search...' class='form-control' value='{{\Request::get("s")}}'>
                <input style="display: inline-block" type='submit' value='Search' class='btn btn-primary m-2'>
            </form>
        </div>

        <h5>Manage Blog Posts</h5>
    @endif

    @forelse($posts as $post)
        @if(isset($post->indexable))
            <?php $post = $post->indexable; ?>
        @endif
        <div class="card m-4" style="">
            <div class="card-body">
                <h5 class='card-title'><a class="a-link-cart-color" href='{{$post->url()}}'>{{$post->title}}</a></h5>
                <h5 class='card-subtitle mb-2 text-muted'>{{$post->subtitle}}</h5>
                <p class="card-text">{{$post->html}}</p>

                <?=$post->image_tag("thumbnail", false, "float-right");?>

                <dl class="">
                    <dt class="">Author</dt>
                    <dd class="">{{$post->author_string()}}</dd>
                    <dt class="">Posted at</dt>
                    <dd class="">{{$post->posted_at}}</dd>


                    <dt class="">Is published?</dt>
                    <dd class="">

                        {!!($post->is_published ? "Yes" : '<span class="border border-danger rounded p-1">No</span>')!!}

                    </dd>

                    <dt class="">Categories</dt>
                    <dd class="">
                        @if(count($post->categories))
                            @foreach($post->categories as $category)
                                <a class='btn btn-outline-secondary btn-sm m-1' href='{{$category->edit_url()}}'>
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>

                                    {{$category->category_name}}
                                </a>
                            @endforeach
                        @else No Categories
                        @endif

                    </dd>
                </dl>


                @if($post->use_view_file)
                    <h5>Uses Custom Viewfile:</h5>
                    <div class="m-2 p-1">
                        <strong>View file:</strong><br>
                        <code>{{$post->use_view_file}}</code>

                        <?php

                        $viewfile = resource_path("views/custom_blog_posts/" . $post->use_view_file . ".blade.php");


                        ?>
                        <br>
                        <strong>Full filename:</strong>
                        <br>
                        <small>
                            <code>{{$viewfile}}</code>
                        </small>

                        @if(!file_exists($viewfile))
                            <div class='alert alert-danger'>Warning! The custom view file does not exist. Create the
                                file for this post to display correctly.
                            </div>
                        @endif

                    </div>
                @endif


                <a href="{{$post->url()}}" class="card-link btn btn-outline-secondary"><i class="fa fa-file-text-o"
                                                                                          aria-hidden="true"></i>
                    View Post</a>
                <a href="{{$post->edit_url()}}" class="card-link btn btn-primary">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    Edit Post</a>
                <form onsubmit="return confirm('Are you sure you want to delete this blog post?\n You cannot undo this action!');"
                      method='post' action='{{route("binshopsblog.admin.destroy_post", $post->id)}}' class='float-right'>
                    @csrf
                    <input name="_method" type="hidden" value="DELETE"/>
                    <button type='submit' class='btn btn-danger btn-sm'>
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        @if(empty($search))
            <h5>Manage Blog Posts</h5>

            <div class='alert alert-warning'>No posts to show you. Why don't you add one?</div>
        @else
            <div class='search-form-outer mb-3'>
                <form method='get' action='{{route("binshopsblog.admin.searchblog", app('request')->get('locale'))}}' class='text-center'>
                    <input style="display: inline-block; width: 50%" type='text' name='s' placeholder='Search...' class='form-control' value='{{\Request::get("s")}}'>
                    <input style="display: inline-block" type='submit' value='Search' class='btn btn-primary m-2'>
                </form>
            </div>
            <div class='alert alert-warning'>There were no results for this search!</div>
        @endif
    @endforelse
@endsection
