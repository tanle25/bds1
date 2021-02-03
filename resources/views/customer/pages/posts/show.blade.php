@extends('customer.layouts.main')

@section('preset_seo')
    @php
        $custom_title = $post->name ?? '';
        $custom_description = Str::limit($post->short_description, 200, '...') ?? '';
        $custom_og_image = $post->thumb ?? '';
    @endphp
@endsection

@section('title'){{$seo->title ?? $post->name}}@endsection

@section('css')
    <style>
        .post-content img{
            max-width: 100% !important;
            height: auto !important;
        }

    </style>
@endsection
@section('content')
<div class="single-post hrm-bg-secondary">
	<div class="container pt-3">
        {{\App\Helpers\Breadcrumbs\PostBreadcrumbHelper::render($post->categories->first())}}

		<div class="row  mt-3">
			<div class="col-md-8 rounded">
                <div class="content bg-white  p-3">
                    <header class="entry-header">
                        <h1 class="font-15 ">{{$post->name ?? ''}}</h1>
                    </header>
                    <div class="meta-share">
                        <div class="post-meta mb-2 font-9 d-md-flex align-items-center">
                            @foreach ($post->categories as $item)
                            <a class="label" href="/tin-tuc/{{$item->slug ?? ''}}"><span>{{$item->name}}</span></a> &nbsp;
                            @endforeach
                            <span class="post-date"> <i class="fa fa-clock-o" aria-hidden="true"></i>{{$date_string}}</span>
                            <span class="ml-auto">
                                @include('customer.components.share_button')
                            </span>
                        </div>
                        <div class="mb-3" style="font-weight: 500">
                            {{$post->short_description ?? ''}}
                        </div>
                        <div class="post-share">
                        </div>
                    </div>
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>
                </div>
                <div class="blog-post post-related  bg-white mt-3">
                    <h2 class="font-15 p-3 related-title">Các tin liên quan</h2>
                    <div class="list-blog-post list-related">
                        @foreach ($related_post as $post)
                        <div class="category-blog p-3 rounded-1 bg-white">
                            <div class="top-post row">
                                <div class="col-4 col-md-3 p-0 px-md-3">
                                    <a class="d-block rounded-1 img-wraper pl-2 pl-md-0" href="{{route('customer.post.show',['cat_slug' => $post->categories->first()->slug ?? 'danh-muc', 'post_slug' => $post->slug] )}}">
                                        <img style="max-height: 175px" class="rounded" src="{{$post->thumb ?? ''}}" alt="{{$post->name ?? ''}}">
                                    </a>
                                </div>
                                <div class="post-link col-8 col-sm-9 pl-md-0 ">
                                    <a style="font-weight: 500" class="font-10 font-md-12 text-dark post-title" href="{{route('customer.post.show',['cat_slug' => $post->categories->first()->slug ?? 'danh-muc', 'post_slug' => $post->slug] )}}">{{$post->name}}</a>
                                    <div class="mt-2 d-md-block d-none">
                                        <span class="font-9 post-description ">
                                            {{$post->short_description}}
                                        </span>
                                    </div>
                                    <div class="cl-main-text mt-1 font-9 text-muted">
                                        {{App\Helpers\TimeHelper::getDateDiffFromNow($post->created_at)['string'] ?? ''}} trước
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-1">
                    @endforeach
                    </div>
                </div>
			</div>
			@include('customer.pages.posts.sidebar', [
                'weekly_news' => $weekly_news,
            ])
		</div>
	</div>
</div>
@endsection

@section('script')
    @parent
    <script>
        maxText($('.blog_excerpt'), 90);

        $('.post-description').each(function(){
            maxText($(this), 180);
        })


        function addVisit(type, id){
            $.ajax({
                url: '/api/visit/store',
                type: 'POST',
                data: {
                    type: type,
                    id: id
                }
            })
        }

        $(document).ready(function(){
            addVisit('post', {{$post->id}});
        })
    </script>


@endsection
