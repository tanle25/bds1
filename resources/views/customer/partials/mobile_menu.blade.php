<nav id="menu-responsive" class="d-md-none">
    <ul>
        <li class="border-bottom">
            @if (Auth::check())
            <div class="login-logout">
                <a class="text-dark font-9 py-2" href="/tai-khoan">
                    <img src="{{auth()->user()->profile_image_path ?? '/images/empty-avatar.jpg'}}" style="width: 50px; height:50px" alt="">
                    <span class="px-2">{{auth()->user()->name}}</span>
                </a>
                <a href="/dang-tin" class="font-10 font-500 hrm-btn-info p-2"><strong>Đăng tin</strong></a>
            </div>
            @else
            <div class="login-logout row">
                <div class="col-6 p-2">
                    <span href="#" class="mobile-login-btn font-9 btn-outline-info btn w-100" data-toggle="modal" data-target="#register">Đăng ký</span>
                </div>
                <div class="col-6 p-2">
                    <span href="#" class="mobile-logout-btn font-9 btn-outline-info btn w-100" data-toggle="modal" data-target="#popup-login"><span>Đăng nhập</span></span>
                </div>
                <div class="col-12 p-2">
                    <span href="#" class="mobile-logout-btn font-9 btn-info btn w-100" data-toggle="modal" data-target="#popup-login"><span>Đăng Tin</span></span>
                </div>
            </div>
            @endif
        </li>
        @foreach ($main_menu as $item)
            <li>
                <a href="{{$item->href ?? '#'}}"> <i class="{{$item->icon}} font-12 pr-2" aria-hidden="true"></i> {{$item->title}} </a>
                @isset($item->childs)
                    @if ($item->childs->isNotEmpty())
                        <ul>
                            @foreach ($item->childs as $child)
                            <li><a href="{{$child->href}}">{{$child->title}}</a></li>
                            @endforeach
                        </ul>
                    @endif
                @endisset
            </li>
        @endforeach
        @if (Auth::check())
        <li>
            <a class="font-9" href="/logout"><span><i class="far fa-sign-out-alt pr-2 font-12"></i> Đăng xuất</span></a>
        </li>
        @endif
    </ul>
</nav>
