@extends('customer.layouts.main')

@section('title')
Tin tức bất động sản
@endsection

@section('content')
<div class="blog-wrapper blog-post hrm-bg-secondary">
	<div class="container pt-3">
        {{\App\Helpers\Breadcrumbs\PostBreadcrumbHelper::render($post_categories->first())}}

		<div class="entry-head my-3">
			<h1 class="font-15 entry-title">{{$category->name}}</h1>
		</div>
		<div class="row m-0">
			<div class="col-md-8 bg-white">
                <div>
                    @foreach ($posts as $post)
                        <div class="category-blog p-3 rounded-1 bg-white">
                            <div class="top-post row">
                                <div class="col-md-5 col-3 p-0 px-md-3">
                                    <a class="d-block rounded-1 img-wraper" href="{{route('customer.post.show',['cat_slug' => $post->categories->first()->slug ?? 'danh-muc', 'post_slug' => $post->slug] )}}">
                                        <img style="max-height: 175px" class="rounded" src="{{$post->thumb ?? ''}}" alt="{{$post->name ?? ''}}">
                                    </a>
                                </div>
                                <div class="post-link col-sm-7 col-9 pl-md-0 ">
                                    <a style="font-weight: 500" class="font-10 font-md-12 text-dark post-title" href="{{route('customer.post.show',['cat_slug' => $post->categories->first()->slug ?? 'danh-muc', 'post_slug' => $post->slug] )}}">{{$post->name ?? ''}}</a>
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
                {{$posts->links()}}
            </div>
                @include('customer.pages.posts.sidebar')
		</div>
	</div>
</div>
@endsection

@section('script')
    @parent
    <script>

        $('.post-description').each(function(){
            maxText($(this), 180);
        })

        $('.head-posts').owlCarousel({
            loop:true,
            autoplay:false,
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            margin: 20,
            dots:false,
            nav:true,
            autoplayTimeout:3000,
            autoplaySpeed:1200,
            smartSpeed:1200,
            navText:["<div class='owl-nav-btn prev-slide'><i class='fas fa-chevron-left'></i></div>","<div class='owl-nav-btn next-slide'><i class='fas fa-chevron-right'></i></div>"],
            responsive:{
                0:{
                    items:1,
                }
            }
        });
    </script>
@endsection
