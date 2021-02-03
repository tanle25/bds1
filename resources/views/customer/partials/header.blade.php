@php
	$logos = explode(',', $theme_options['logo'] ?? '');
	$logo = '';
	foreach ($logos as $temp) {
		if ($temp != '') {
			$logo = $temp;
		}
	}
@endphp
@section('css')
    <style>
        .menu-open{
            margin: 0;
            padding: 0;
            top:0;
        }
    </style>
@endsection
{{-- <div class="menu-responsive-overlay"></div> --}}
<div class="navigation sticky-top bg-info">
    <div class="header-container border-bottom">
        <header class="">
            <section class=" container menu-desktop d-none d-md-flex justify-content-center align-items-center pb-3">
                <div class="navbar-header">
                    <div class="" id="brand">
                        <a href="/"><img class="lazy" style="max-height: 60px" data-src="{{$logo}}" alt="brand"></a>
                    </div>
                </div>
                <div class="d-block pr-3">
                    <a style="position: relative; width: auto; top:0; z-index:2"  href="#" class="pl-3 d-xl-none menu-open font-15 text-secondary" ><i class="far fa-bars"></i></a>
                </div>
                <div class="header-right ml-auto d-none d-xl-flex align-items-center">

                    @if (Auth::check())
                        @php
                            $featured_posts = Auth::user()->featured_realties;
                            @endphp
                        <a href="/dang-tin" class="ml-2 font-9 btn-info text-secondary p-2"><strong>Đăng tin</strong></a>
                        <div class="dropdown featured-top">
                            <span style="line-height: 1.6em"  class="btn bg-info text-secondary rounded-circle px-2 py-1 list-featured-btn font-12" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                <strong class="font-9">Yêu thích</strong>
                                <i class="far fa-heart"></i>
                            </span>
                            <div class="dropdown-menu dropdown-menu-center mt-3 shadow-10 border-0 " style="width:400px; z-index: 100" aria-labelledby="dropdownMenuButton1">
                                <div class="text-center border-bottom py-2 font-11"><strong>Tin đăng đã lưu</strong></div>
                                @if ($featured_posts->isNotEmpty())
                                <div class=" featured-body">
                                    @if ($featured_posts->isNotEmpty())
                                        @foreach ($featured_posts->take(6) as $item)
                                        <div class="border-bottom featured-item-wraper py-2 px-3">
                                            <a href="{{$item->link}}" class="d-flex featured-item align-items-center">
                                                <div class="img-wraper flex-fixed-20" style="height:50px">
                                                    <img src="{{$item->thumb}}" class="rounded" alt="" srcset="">
                                                </div>
                                                <div class="px-2 position-relative">
                                                    <div class="main-text text-truncate font-9 font-weight-500" style="max-width: 280px;">{{$item->title}}</div>
                                                    <div class="mt-2 secondary-text font-8">Đăng {{App\Helpers\TimeHelper::getDateDiffFromNow($item->created_at)['string']}} trước</div>
                                                    <button type="button" data-featured-id="{{$item->id}}" class="btn bg-white remove-featured-btn position-absolute"><i class="fal fa-times"></i></button>
                                                </div>
                                            </a>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="text-center py-2 featured-show-all" style="display:block">
                                    <a href="/tin-da-luu">Xem tất cả</a>
                                </div>
                                @else
                                <div class="featured-body">
                                    <div class="text-center">
                                        <img src="/images/icons/empty-state.svg" class="my-5 mx-auto" style="width: 70%" alt="">
                                        <p class="font-11 spacing-1">Bấm <i class="mx-1 font-13 far fa-heart"></i> để lưu tin <br>Và xem lại tin ở đây</p>
                                    </div>
                                </div>
                                <div class="text-center featured-show-all py-2" style="display:none">
                                    <a href="/tin-da-luu">Xem tất cả</a>
                                </div>
                                @endif

                            </div>
                        </div>
                    @else
                    <div class="dropdown featured-top">
                        <span style="line-height: 1.6em"  class="list-featured-btn-unauth btn bg-info text-secondary rounded-circle px-2 py-1 font-12" >
                            <strong class="font-9">Yêu thích</strong>
                            <i class="far fa-heart"></i>
                        </span>
                        <div class="dropdown-menu dropdown-menu-center mt-3 shadow-10 border-0 " style="width:400px; z-index: 100" aria-labelledby="dropdownMenuButton1">
                            <div class="text-center border-bottom py-2 font-11"><strong>Tin đăng đã lưu</strong></div>
                            </div>
                        </div>
                        <a data-toggle="modal" data-target="#popup-login" href="/dang-tin" class="ml-2 font-9 btn-info text-secondary p-2"><strong>Đăng tin</strong></a>
                    @endif
                    {{--ss--}}
                </div>
            </section>
            <div class="bg-primary d-none d-lg-block">
                <nav class="d-flex align-items-center justify-content-between desktop-menu container">
                    @foreach ($main_menu as $item)
                    <div class="menu-item py-2 pr-4 mr-2 @if(isset($item->childs) && $item->childs != []) has-child @endif"><a class="font-weight-600 text-white font-9" href="{{$item->href ?? '#'}}"> {{$item->title}}</a>
                        @isset($item->childs)
                            @if ($item->childs->isNotEmpty())
                                <ul class="child-navigation submenu-1 border px-3 bg-white rounded shadow-10">
                                    @foreach ($item->childs as $child)
                                    <li class="py-2"><a class="main-text" href="{{$child->href}}">{{$child->title}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        @endisset
                    </div>
                    @endforeach
                    <div class="ml-auto header-right d-none d-xl-flex align-items-center py-1">
                        @if (Auth::check())
                        @php
                            $featured_posts = Auth::user()->featured_realties;
                        @endphp
                        <div class="login-logout d-flex align-items-center">

                            <a class="text-dark font-9" href="/tai-khoan">
                                <img data-src="{{auth()->user()->profile_image_path ?? '/images/empty-avatar.jpg'}}" style="width: 40px; height:40px" class="lazy rounded-circle" alt="">
                                <strong class="text-white px-2">{{auth()->user()->name}}</strong>
                            </a>
                            <a class="text-white font-9 font-weight-500 ml-2" href="/logout">Đăng xuất</a>
                        </div>
                        @else
                        <div class="login-logout d-flex align-items-center text-uppercase">
                                <div class="btn">
                                    <a href="/v2/register" target="_blank" class="text-white px-2 font-8" >Đăng ký</a>
                                    <a href="/v2/login" target="_blank" class="text-white font-8" ><span class="border-left px-2">Đăng nhập</span></a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </nav>
            </div>
        </header>
    </div>
    <section class="header-mobile px-3 pt-2 pb-2 d-md-none" style="background: #024073">
        <div class="d-flex justify-content-between align-items-center">
            <div class="nav-search-btn-scroll  w-100" style="display: none">
                <a class="nav-search-open text-dark d-md-none rounded p-2 d-block bg-white" data-toggle="modal" data-target="#nav-search">
                    <i class="far fa-search font-10"></i> <span class="font-9" style="font-weight: 500">Tìm kiếm bất động sản</span>
                </a>
            </div>

            @if (Auth::check())
                @php
                    $featured_posts = Auth::user()->featured_realties;
                @endphp
                <div class="dropdown featured-top">
                    <button class="btn px-2 py-1 list-featured-btn font-15 text-white" style="background: transparent" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                        <i class="far fa-heart"></i>
                    </button>
                    <div class="dropdown-menu mt-3 shadow-10 border-0 " style="width:95vw; z-index: 100" aria-labelledby="dropdownMenuButton1">
                        <div class="text-center border-bottom py-2 font-11"><strong>Tin đăng đã lưu</strong></div>
                        @if ($featured_posts->isNotEmpty())
                        <div class=" featured-body">
                            @if ($featured_posts->isNotEmpty())
                                @foreach ($featured_posts->take(6) as $item)
                                <div class="border-bottom featured-item-wraper py-2 px-3">
                                    <a href="{{$item->link}}" class="d-flex featured-item align-items-center">
                                        <div class="img-wraper flex-fixed-20" style="height:50px">
                                            <img src="{{$item->thumb}}" class="rounded" alt="" srcset="">
                                        </div>
                                        <div class="px-2 position-relative">
                                            <div class="main-text text-truncate font-9 font-weight-500" style="max-width: 280px;">{{$item->title}}</div>
                                            <div class="mt-2 secondary-text font-8">Đăng {{App\Helpers\TimeHelper::getDateDiffFromNow($item->created_at)['string']}} trước</div>
                                            <button type="button" data-featured-id="{{$item->id}}" class="btn bg-white remove-featured-btn position-absolute"><i class="fal fa-times"></i></button>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="text-center py-2 featured-show-all" style="display:block">
                            <a href="/tin-da-luu">Xem tất cả</a>
                        </div>
                        @else
                        <div class="featured-body">
                            <div class="text-center">
                                <img src="/images/icons/empty-state.svg" class="my-5 mx-auto" style="width: 70%" alt="">
                                <p class="font-11 spacing-1">Bấm <i class="mx-1 font-13 far fa-heart"></i> để lưu tin <br>Và xem lại tin ở đây</p>
                            </div>
                        </div>
                        <div class="text-center featured-show-all py-2" style="display:none">
                            <a href="/tin-da-luu">Xem tất cả</a>
                        </div>
                        @endif

                    </div>
                </div>
            @else
                <button class="btn px-2 py-1 list-featured-btn-unauth font-15 text-white" style="background: transparent" type="button" >
                    <i class="far fa-heart"></i>
                </button>
            @endif

            <a  href="/" class="logo-mobile my-2" style="width: 30%"><img class="img-fluid lazy"  data-src="{{$logo}}" alt="brand"></a>
            <a style="position: relative; width: auto; top:0; z-index:2"  href="#" class="pl-3 menu-open font-15 text-white d-md-none" ><i class="far fa-bars"></i></a>
        </div>
        <div class="nav-search-btn">
            <a class="nav-search-open text-dark d-md-none rounded p-2  d-block bg-white w-100" data-toggle="modal" data-target="#nav-search">
                <i class="far fa-search font-10"></i> <span class="font-9" style="font-weight: 500">Tìm kiếm bất động sản</span>
            </a>
        </div>
</section>
</div>

@if (Agent::isMobile())
@include('customer.components.search.nav_search')
@endif

@section('script')
@parent
    <script>
        $(window).on('scroll', function(){
            var top = $(window).scrollTop();
            if (top > 100) {
                $('.nav-search-btn').hide();
                $('.nav-search-btn-scroll').show();
                $('.logo-mobile').hide();
            }else if(top == 0){
                $('.nav-search-btn').show();
                $('.nav-search-btn-scroll').hide();
                $('.logo-mobile').show();
            }
        })
        $(document).on('click', '.header-right .dropdown-menu', function (e) {
            e.stopPropagation();
        });
        $('.list-featured-btn-unauth').click(function(){
            swalAlert('Bạn vui lòng đăng nhập để thực hiện lưu và xem lại tin', 'error')
        })
    </script>
@endsection
