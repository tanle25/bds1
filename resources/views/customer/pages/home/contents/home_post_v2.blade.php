<section class="home-post py-3 py-lg-5 section bg-white">
	<div class="container">
        <div class="row p-0">
            <div class="col-md-9 home-posts">
                <div class="border-bottom mb-3 d-flex align-items-center">
                    <div class="w-100">
                        <ul class="post-category-list owl-carousel px-0 my-0">
                            @foreach ($home_featured_cats as $index =>  $post_category)
                            <li class="nav-item item mr-4 inline-block">
                                <a @if(Agent::isMobile()) style="font-size: 1.1rem !important"  @endif class="nav-link font-13 text-secondary home-title px-0 @if($index == 0) active @endif" data-toggle="tab" href="#cat{{$post_category->id}}"><strong>{{$post_category->name}}</strong></a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="ml-auto  align-items-center d-none d-md-flex" style="flex: 0 0 150px">
                        <a href="/tin-tuc" class="text-dark">Xem tất cả <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>
                <!-- Tab panes -->
                <div class="tab-content">
                    @foreach ($home_featured_cats as $index =>  $post_category)
                    <div class="tab-pane @if($index == 0) active @else fade @endif  p-0" id="cat{{$post_category->id}}">
                        <div class="row">
                            @php
                                $top_post = $post_category->posts->sortByDesc('id')->first();
                                if ($top_post) {
                                    $link = route('customer.post.show',['cat_slug' => $post_category->slug ?? 'danh-muc', 'post_slug' => $top_post->slug] );
                                }
                            @endphp
                            <div class="col-md-6">
                                @if ($top_post)
                                <a href=""class="d-block img-wraper rounded pt-2 mb-3" style="overflow:hidden">
                                    <img class="img-fluid" style="height: 264px" src="{{Str::replaceLast(',', '', $top_post->avatar) ?? ''}}" alt="" srcset="">
                                </a>
                                <a class="font-12 main-text "  href="{{$link ?? '#' }}"><strong class="mt-3"> {{$top_post->name}}</strong></a>
                                <p class="pt-2 text-secondary"><i class="far fa-clock"></i> {{App\Helpers\TimeHelper::getDateDiffFromNow($top_post->created_at)['string'] ?? ''}} trước</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @foreach ($post_category->posts->sortByDesc('id')->skip(1)->take(7) as $post)
                                    @php
                                        $link = route('customer.post.show',['cat_slug' => $post_category->slug ?? 'danh-muc', 'post_slug' => $post->slug] )
                                    @endphp
                                    <div class="row mb-3 mb-md-0 px-2 ">
                                        <a href="{{$link}}" class="col-4 d-md-none d-block embed-responsive embed-responsive-16by9">
                                            <img class="embed-responsive-item" src="{{$post->thumb}}" alt="{{$post->name}}">
                                        </a>
                                        <a class="col-8 font-md-10 col-md-12 pl-2 d-block w-75 secondary-text border-md-bottom py-2" href="{{$link}}">
                                            <span class="font-9 font-md-11 font-weight-md-400 font-weight-600">{{Str::limit($post->name, 70, "...")}}</span>
                                            <span class="d-block pt-1 font-8 d-md-none text-secondary"><i class="far fa-clock"></i> {{App\Helpers\TimeHelper::getDateDiffFromNow($post->created_at)['string'] ?? ''}} trước</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <a class="font-weight-500 font-9 d-md-none" href="/tin-tuc/{{$post_category->slug ?? ''}}">Xem thêm ...</a>
                </div>
            </div>
            <div class="col-md-3 pt-3">
                @isset($vertical_advertisments)
                    @include('customer.components.advertisments.vertical', ['items' => $vertical_advertisments, 'items_mobile' => $mobile_vertical_advertisments])
                @endisset
            </div>
        </div>
	</div>
</section>

@section('script')
@parent
    <script>
    $('.post-category-list').owlCarousel({
        autoplay:false,
        autoWidth:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        dots:false,
        nav:false,
        smartSpeed:1000,
        animateOut: 'fadeOut',
    });

    $('.nav-link').on('click', function(){
        $('.nav-link').removeClass('active');
        $(this).addClass("active");
        var id = $(this).attr('href');
        $('.tab-pane').addClass('fade');
        $('.tab-pane').removeClass('active');
        $('.tab-pane' + id).removeClass('fade');
        $('.tab-pane' + id).addClass('active');

    })
    </script>
@endsection
