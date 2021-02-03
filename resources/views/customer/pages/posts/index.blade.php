@extends('customer.layouts.main')

@section('title')
Tin tức bất động sản
@endsection

@section('css')
@parent
<style>

    .category-post-title{
        line-height: 22px;
    }
    .category-post-title:before{
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #eb5155;
        display: inline-block;
        float: left;
        margin-top: 7px;
        margin-right: 8px;
        flex: 0 0 6px;
    }

    .province{
        line-height: 30px;
    }
</style>
@endsection

@section('content')
<div class="blog-wrapper blog-post hrm-bg-secondary">
	<div class="container pt-4">
        <div class="breadcrumbs">
            <a class="secondary-text" href="/">Trang chủ</a>
            / <a class="main-text" href="#">Tin tức</a>
        </div>
		<div class="entry-head pt-2">
			<h1 class="font-20 home-title">Tin tức bất động sản</h1>
        </div>
        @php
        $top_post = $featured_posts->first();
        @endphp
		<div class="row">
			<div class="col-md-8">
				<div class="featured-blog p-4 rounded-1 bg-white">
                    <div class="top-post row">
                        <div class="col-sm-5">
                            <a class="rounded-1 d-block img-wraper" href="{{route('customer.post.show',['cat_slug' => $top_post->categories->first()->slug ?? 'danh-muc', 'post_slug' => $top_post->slug] )}}"><img  style="max-height: 200px" src="{{$top_post->thumb ?? ''}}" alt="{{$top_post->name ?? ''}}">
                            </a>
                        </div>
                        <div class="post-link col-sm-7 pl-sm-0">
                            <a style="font-weight: 500" class="font-13 main-text" href="{{route('customer.post.show',['cat_slug' => $top_post->categories->first()->slug ?? 'danh-muc', 'post_slug' => $top_post->slug] )}}">{{$top_post->name}}</a>
                            <div class="mt-2">
                                <span class="font-10 post-description">
                                    {{$top_post->short_description}}
                                </span>
                            </div>
                            <div class="cl-main-text mt-3">
                                {{App\Helpers\TimeHelper::getDateDiffFromNow($top_post->created_at)['string'] ?? ''}} trước
                            </div>
                            <div>
                                @foreach ($top_post->tags->take(3) as $tag)
                                <a href="{{route('customer.post_tag.get_all', $tag->slug)}}" class="d-inline-block py-1 px-2 my-2  mr-2 hrm-btn-info-solid">
                                    <strong class="font-9">#{{$tag->name}}</strong>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="featured-post-slider owl-carousel mt-4">
                        @foreach ($featured_posts as $item)
                            <div class="item rounded-1">
                                <a class="main-text" href="{{route('customer.post.show',['cat_slug' => $item->categories->first()->slug ?? 'danh-muc', 'post_slug' => $item->slug] )}}">
                                    <div>
                                        <img style="height: 140px" src="{{$item->thumb}}" alt="">
                                    </div>
                                    <div class="post-title main-text pt-3">
                                    {{Str::limit($item->name, 40, '')}}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                @foreach ($post_categories->take(4) as $category)
                    @php
                        $top_post = $category->posts->sortByDesc('id')->first();
                        $posts = $category->posts->sortByDesc('id');
                    @endphp
                    @if ($posts->isNotEmpty())
                        <div class="category-posts mt-5">
                            <div class="category-header d-flex align-items-center justify-content-between mb-1">
                                <h3 class="p-0 bold home-title"><strong  class="uppercase">{{$category->name}}</strong></h3>
                                <a class="secondary-text" href="{{route('customer.post.show_by_category', $category->slug)}}"><span>Xem thêm</span>&nbsp; <i class="fa fa-chevron-right secondary-text font-9" aria-hidden="true"></i></a>
                            </div>
                            <div class="category-body">
                                <div class="category-blog p-4 rounded-1 bg-white">
                                    <div class="top-post row">
                                        <div class="col-sm-5">
                                            <a class="d-block rounded-1 img-wraper" href="{{route('customer.post.show',['cat_slug' => $top_post->categories->first()->slug ?? 'danh-muc', 'post_slug' => $top_post->slug] )}}">
                                                <img style="max-height: 200px" src="{{$top_post->thumb ?? ''}}" alt="{{$top_post->name ?? ''}}">
                                            </a>
                                        </div>
                                        <div class="post-link col-sm-7 pl-sm-0">
                                            <a style="font-weight: 500" class="font-13 main-text" href="{{route('customer.post.show',['cat_slug' => $top_post->categories->first()->slug ?? 'danh-muc', 'post_slug' => $top_post->slug] )}}">{{$top_post->name}}</a>
                                            <div class="mt-2">
                                                <span class="font-10 post-description ">
                                                    {{$top_post->short_description}}
                                                </span>
                                            </div>
                                            <div class="cl-main-text mt-3 text-muted">
                                                {{App\Helpers\TimeHelper::getDateDiffFromNow($top_post->created_at)['string'] ?? ''}} trước
                                            </div>
                                            <div>
                                                @foreach ($top_post->tags->take(3) as $tag)
                                                <a href="{{route('customer.post_tag.get_all', $tag->slug)}}" class="d-inline-block py-1 px-2 my-2 mr-2 hrm-btn-info-solid">
                                                    <strong class="font-9">#{{$tag->name}}</strong>
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        @foreach ($posts->take(6) as $item)
                                        <div class="col-sm-6  pb-3">
                                            <a class="main-text d-flex post-title category-post-title cl-main-text" href="{{route('customer.post.show',['cat_slug' => $item->categories->first()->slug ?? 'danh-muc', 'post_slug' => $item->slug] )}}">
                                                {{$item->name}}
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
			</div>
			@include('customer.pages.posts.sidebar')
    </div>
	</div>
</div>
@endsection

@section('script')
    @parent
    <script>

        $('.featured-post-slider').owlCarousel({
            margin: 20,
            dots:false,
            nav:true,
            autoplay: true,
            autoplayTimeout:3000,
            autoplaySpeed:1200,
            smartSpeed:1200,
            navText:["<div class='owl-nav-btn  prev-slide'><i class='fas fa-chevron-left'></i></div>","<div class='owl-nav-btn next-slide '><i class='fas fa-chevron-right'></i></div>"],
            responsive:{
                0:{
                    items:2,
                },
                600:{
                    items:3
                },
                1000:{

                    items:3.5
                }
            }
        });

        $('.post-title').each(function(){
            maxText($(this), 100);
        })

        $('.post-description').each(function(){
            maxText($(this), 140);
        })
        maxText($('.blog_excerpt'), 90);

    </script>
@endsection
