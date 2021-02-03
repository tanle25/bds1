@extends('admin.main_layout')
@section('title')
    Tạo mới tài liệu
@endsection
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
@include('admin.partials.content_header', ['title' => 'Tạo mới tài liệu'])
<section class="content" >
    <div class="container-fluid ">
        <form action="{{route('admin.craw.getByLink')}}" method="post" class="row">
            @csrf
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin bài viết</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="post_name">Nhập link bài viết viết (<span class="text-red">*</span>)</label>
                            <input
                            name="link"
                            type="text"
                            class="form-control @error('link') is-invalid @enderror"
                            id="post_link"
                            placeholder="Nhập link bài viết từ domain https://dantri.com.vn"
                            value="{{$post->link ?? old('link')}}"
                            >
                            @error('link')
                            <div id="" class="error invalid-feedback d-block">
                                    {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Lấy dữ liệu</button>
                </div>

            </div>
            <div class="col-md-3">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ảnh đại diện</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group ">
                            @include('admin.components.button_file_manager', ['id' => 'avatar',
                            'input_name' => 'avatar',
                            'current_input' => $post->avatar ?? old('avatar')
                            ])
                        </div>
                        <div class="form-group">
                            <label for="post_name">Danh mục bài viết (<span class="text-red">*</span>)</label>
                            <select name="categories[]" multiple="multiple" class="form-control select2 select2-info"
                                data-dropdown-css-class="select2-info" style="width: 100%;">
                                @foreach ($categories as $item)
                                <option
                                value="{{$item->id}}"
                                >
                                    {{$item->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>
@endsection
