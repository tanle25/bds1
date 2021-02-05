@extends('admin.main_layout')
@section('title')
    Tải bất động sản
@endsection
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
@include('admin.partials.content_header', ['title' => 'Tải bất động sản'])
<section class="content" >
    <div class="container-fluid ">
        <form action="{{route('admin.craw.getRealty')}}" method="post" class="row">
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
                            placeholder="Nhập link bài viết từ domain https://alonhadat.com"
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin Bất động sản</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><label>Địa chỉ BĐS</label></div>
                            <div class="col-md-4 form-group">
                                <select class="form-control address_input" name="province" id="province">
                                    <option value="">Tỉnh/Thành phố</option>
                                    @foreach ($provinces as $province)
                                    <option
                                    @if (isset($realty) && $province->code == $realty->province_code) selected @endif
                                    value="{{$province->code}}">{{$province->name_with_type}}</option>
                                    @endforeach
                                </select>
                                @error('province')
                                    <div id="" class="error invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <select class="form-control address_input" name="district" id="district">
                                    <option value="">Huyện/Thị xã</option>
                                    @isset($districts)
                                        @foreach ($districts as $district)
                                        <option
                                        @if ($district->code == $realty->district_code) selected @endif
                                        value="{{$district->code}}">{{$district->name_with_type}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('district')
                                    <div id="" class="error invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <select class="form-control address_input" name="commune" id="commune">
                                    <option value="">Xã/ Phường</option>
                                    @isset($communes)
                                    @foreach ($communes as $commune)
                                    <option
                                    @if ($commune->code == $realty->commune_code) selected @endif
                                    value="{{$commune->code}}">{{$commune->name_with_type}}</option>
                                    @endforeach
                                    @endisset
                                </select>
                                @error('commune')
                                    <div id="" class="error invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin liên hệ</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Tên người dùng</label>
                                <input
                                type="text"
                                class="form-control"
                                name="contact_name"
                                placeholder="Tên người dùng"
                                @isset($realty_post)
                                value="{{$realty_post->contact_name ?? old("contact_name")}}"
                                @endisset
                                >
                                @error('contact_name')
                                <div id="" class="error invalid-feedback d-block">
                                    {{$message}}
                                </div>
                                @enderror

                            </div>
                            <div class="col-md-6 form-group">
                                <label>Số điện thoại</label>
                                <input
                                type="text"
                                class="form-control"
                                name="contact_phone_number"
                                placeholder="Số điện thoại"
                                @isset($realty_post)
                                value="{{$realty_post->contact_phone_number ?? old('contact_phone_number')}}"
                                @endisset
                                >
                                @error('contact_phone_number')
                                <div id="" class="error invalid-feedback d-block">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email liên hệ</label>
                            <input
                            type="text"
                            class="form-control"
                            name="contact_email"
                            placeholder="Email"
                            @isset($realty_post)
                            value="{{$realty_post->contact_email ?? old("contact_email")}}"
                            @endisset
                            >
                            @error('contact_email')
                            <div id="" class="error invalid-feedback d-block">
                                {{$message}}
                            </div>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input
                            type="text"
                            class="form-control"
                            name="contact_address"
                            placeholder="Nhập địa chỉ"
                            @isset($realty_post)
                            value="{{$realty_post->contact_address ?? old("contact_address")}}"
                            @endisset
                            >
                            @error('contact_address')
                            <div id="" class="error invalid-feedback d-block">
                                {{$message}}
                            </div>
                            @enderror

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Trạng thái </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control select2 select2-info" value="" name="status" data-dropdown-css-class="select2-info"
                                style="width: 100%;">
                                <option value="1" @if (isset($realty_post) && $realty_post->status == 1) selected @endif >Tin chưa duyệt</option>
                                <option value="2" @if (isset($realty_post) && $realty_post->status == 2) selected @endif >Đã thanh toán</option>
                                <option value="3" @if (isset($realty_post) && $realty_post->status == 3) selected @endif >Tin đã duyệt</option>
                                <option value="4" @if (isset($realty_post) && $realty_post->status == 4) selected @endif >Tin rác</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lịch đăng tin</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Loại tin đăng</label>
                            <select class="form-control select2 select2-info" value="" name="rank" data-dropdown-css-class="select2-info"
                                style="width: 100%;">
                                <option value="1" @if (isset($realty_post) && $realty_post->rank == 1) selected @endif >Tin thường</option>
                                <option value="2" @if (isset($realty_post) && $realty_post->rank == 2) selected @endif >Tin Vip</option>
                                <option value="3" @if (isset($realty_post) && $realty_post->rank == 3) selected @endif >Tin ưu đãi</option>
                                <option value="4" @if (isset($realty_post) && $realty_post->rank == 4) selected @endif >Tin Vip đặc biệt</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="">Ngày bắt đầu</label>
                            <input
                            id="date-picker"
                            @isset($realty_post)
                            value="{{Carbon\Carbon::parse( $realty_post->open_at)->format('d/m/Y') ?? old("open_at")}}"
                            @endisset
                            class="date-picker form-control"
                            type="text"
                            name="open_at"
                            >
                            @error('open_at')
                            <div class="text-danger">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="">Ngày kết thúc</label>
                            <input
                            id="date-picker"
                            @isset($realty_post)
                            value="{{Carbon\Carbon::parse( $realty_post->close_at)->format('d/m/Y') ?? old("close_at")}}"
                            @endisset
                            class="date-picker form-control"
                            type="text"
                            name="close_at"
                            >
                            @error('close_at')
                            <div class="text-danger">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>
@endsection

@section('script')
    @parent
    <script>


        function getDistricts(province_code){
            url = '/get-district-of-province/' + province_code;
            return $.ajax({
                url: url,
                type: 'get',
            })
        }
        $('#province').on('change', function(){
            var province_code = $(this).val();
            var district_inputs = '<option value="">Quận/Huyện</option>';
            getDistricts(province_code)
            .done(function(data){
                data.forEach(element => {
                    district_inputs += `<option value="${element.code}">${element.name_with_type}</option>`;
                });
                $('#district').html(district_inputs);
            });
        })

        function getCommunes(district_code){
            url = '/get-commune-of-district/' + district_code;
            return $.ajax({
                url: url,
                type: 'get',
            })
        }

        $(document).on('change', "#district" , function(){
            var district_code = $(this).val();
            var commune_inputs = '<option value="">Phường/Xã</option>';
            getCommunes(district_code)
            .done(function(data){
                data.forEach(element => {
                    commune_inputs += `<option value="${element.code}">${element.name_with_type}</option>`;
                });
                $('#commune').html(commune_inputs);
            });
        })
    </script>
@endsection
