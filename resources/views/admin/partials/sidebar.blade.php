<!-- Main Sidebar Container -->
@php
    $logo = Str::replaceLast(',', '', $theme_options['logo']);
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link  text-center">
        <img src="{{$logo ?? ''}}" style="max-width: 80%">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3">
            <div class="d-flex user-panel" style="border-bottom: none">
                <div class="image d-flex align-items-center">
                    <img src="{{asset('template/AdminLTE/dist/img/user6-128x128.jpg')}}"
                        class="img-circle elevation-2 d-block" alt="User Image'">
                </div>
                <div class="info">
                    <a href="#" class="d-block font-weight-bold" style="font-size: 1.1rem">{{Auth::user()->fullname ??
                        ''}}</a>
                </div>
            </div>

        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas nav-icon fa-tv"></i>
                        <p>
                            Cấu hình hiển thị
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/menu-category" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quản lý menu</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/admin/theme-options" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Giao diện website</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/admin/widget" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cấu hình nội dung</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/admin/filemanager" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quản lý ảnh</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/admin/seo" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quản lý SEO</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Quản lý tin rao vặt
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.realty_post.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách tin rao vặt</p>
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="{{route('admin.realty_post.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tạo mới tin rao vặt</p>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{route('admin.post_rank.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quản lý loại tin đăng</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="far  fa-newspaper nav-icon"></i>
                        <p>
                            Bài viết
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.post.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách bài viết</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.post_category.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh mục bài viết</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Tag
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/tag" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách tag</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas nav-icon fa-hand-holding-usd"></i>
                        <p>
                            Thanh toán
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/bill" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Yêu cầu nạp tiền</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-archway"></i>
                        <p>
                            Dự án
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/project" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách dự án</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="/admin/contact" class="nav-link">
                        <i class="fas fa-phone-alt nav-icon"></i>
                        <p>
                            Liên hệ
                            {{-- <i class="fas fa-angle-left right"></i> --}}
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="/admin/admin-manager" class="nav-link">
                        <i class="fas fa-user-shield nav-icon"></i>
                        <p>
                            Quản trị viên
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="/admin/customer-manager" class="nav-link">
                        <i class="fas fa-user nav-icon"></i>
                        <p>
                            Khách hàng
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-tools nav-icon"></i>
                        <p>
                            Cài đặt
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/bank" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ngân hàng VNPAY</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-map-marked-alt nav-icon"></i>
                        <p>
                            Đơn vị hành chính
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/province" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tỉnh / Thành phố</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/district" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quận / Huyện</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/commune" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Xã / Phường</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas nav-icon fa-ad"></i>
                        <p>
                            Tiện ích khác
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/advertisment" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quảng cáo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/partner" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đối tác</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
