<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label">Tiêu đề bài đăng<span class="text-danger">*</span></label>
            <div class="row">
                <div class="col-md-12">
                    <input id="title" type="text" name="title" class="form-control" placeholder="Nhập tiêu đề" value="{{$realty_post->title ?? old('title')}}" >
                    @error('title')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Loại hình giao dịch <span class="text-danger">*</span></label>
            <div class="row">
                @foreach (config('constant.realty_post_type') as $index => $item)
                <div class="bl-radio col-md-6">
                    <input data-realty-type="{{implode(',', config('constant.realty_post_type.'.$index.'.realty_type_list'))}}" type="radio" name="realty_post_type" id="listingType-{{$index}}" value="{{$index}}" class="listingType"
                    @isset($realty_post)
                        @if ($realty_post->type == $index)
                        checked
                        @endif
                    @else
                        @if ($index == 1)
                        checked
                        @endif
                    @endisset
                    >
                    <label for="listingType-{{$index}}"> {{$item['name']}} </label>
                </div>
                @endforeach
            </div>
            @error('realty_post_type')
            <div class="text-danger">
                {{$message}}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Loại hình bất động sản <span class="text-danger">*</span></label>
            <div>
                <select name="realty_type" class="form-control">
                    @foreach (config('constant.realty_type') as $index => $item)
                    <option
                    @isset($realty_post)
                        @if ($realty->type == $index)
                        selected
                        @endif
                    @else
                        @if ($index == 1)
                        selected
                        @endif
                    @endisset
                    class="realty-type-item"
                    value="{{$index}}"
                    >
                    {{$item['name']}}
                    </option>
                    @endforeach
                </select>

                @error('realty_type')
                <div class="text-danger">
                    {{$message}}
                </div>
                @enderror
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Diện tích (m<sup>2</sup> )<span class="text-danger">*</span></label>
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0 col-sm-4 area-fav">
                    <input id="area" type="number" name="area" class="form-control" placeholder="Diện tích"
                    value="{{$realty->area ?? old('area')}}"
                    >
                    @error('area')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <select class="form-control" id="direction" name="direction">
                        @php
                            $direction = $realty->direction ?? null;
                        @endphp
                        <option @if($direction == null) selected @endif value="">Hướng</option>
                        <option @if($direction == 1) selected @endif value="1">Đông</option>
                        <option @if($direction == 2) selected @endif value="2">Tây</option>
                        <option @if($direction == 3) selected @endif value="3">Nam</option>
                        <option @if($direction == 4) selected @endif value="4">Bắc</option>
                        <option @if($direction == 5) selected @endif value="5">Đông Bắc</option>
                        <option @if($direction == 6) selected @endif value="6">Đông Nam</option>
                        <option @if($direction == 7) selected @endif value="7">Tây Bắc</option>
                        <option @if($direction == 8) selected @endif value="8">Tây Nam</option>
                    </select>
                    @error('direction')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <label class="control-label">Số phòng</label>
                    <input id="number_of_floors" type="number" name="number_of_floors" class="form-control" placeholder="Số tầng" value="{{$realty->number_of_floors ?? old('number_of_floors')}}" >
                    @error('number_of_floors')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="col-md-4 has-errors mb-3 mb-md-0">
                    <label class="control-label">Số phòng tắm</label>
                    <input id="number_of_bath_rooms" type="number" name="number_of_bath_rooms" class="form-control" placeholder="Phòng tắm" value="{{$realty->number_of_bath_rooms ?? old('number_of_bath_rooms')}}" >
                    @error('number_of_floors')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="form-group">
                        <label class="control-label">Số phòng ngủ</label>
                        <input type="number" name="number_of_bed_rooms" id="" class="form-control" placeholder="Phòng ngủ" aria-describedby="" value="{{$realty->number_of_bed_rooms ?? old('number_of_bed_rooms')}}">
                    </div>
                    @error('number_of_bed_rooms')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6 col-sm-4 price-fav mb-3 mb-md-0">
                    <label class="control-label">Giá đề nghị <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" class="form-control" placeholder="Giá đề nghị" value="{{$realty_post->price ?? old('price')}}" onkeyup="onChangeInput(event);">
                    @error('price')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror

                </div>
                <div class="col-sm-6 col-rate mb-3 mb-md-0">
                    <div class="row">
                        <div class="">
                            <label class="control-label">Đơn vị <span class="text-danger">*</span></label>
                            <select class="form-control" id="price_type" name="price_type">
                                @foreach (config('constant.price_type') as $index => $item)
                                    <option
                                    @isset($realty_post)
                                        @if ($realty_post->price_type == $index)
                                            selected
                                        @endif
                                    @endisset
                                    value="{{$index}}">{{$item['back_view']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="price_word font-8 pl-2 pt-1">
                <em>

                </em>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Địa chỉ BĐS <span class="text-danger">*</span></label>
            <div class="row">
                <div class="col-md-4 col-sm-4 mb-3 mb-md-0">
                    <select class="form-control address_input" id="province" name="province">
                        <option value="">Tỉnh/Thành phố</option>
                        @php
                            $province_code = $realty->province_code ?? null
                        @endphp
                        @foreach ($provinces as $item)
                            <option @if($province_code == $item->code) selected @endif value="{{$item->code}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('province')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 col-sm-4 select-district-fav mb-3 mb-md-0">
                    <select class="form-control address_input" id="district" name="district">
                        <option value="">Quận/Huyện</option>
                        @isset($districts)
                            @foreach ($districts as $district)
                            <option
                            @if ($district->code == $realty->district_code) selected @endif
                            value="{{$district->code}}">{{$district->name_with_type}}</option>
                            @endforeach
                        @endisset
                    </select>
                    @error('district')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 col-sm-4 select-ward-fav mb-3 mb-md-0">
                    <select class="form-control address_input" id="commune" name="commune">
                        <option value="">Phường/Xã</option>
                        @isset($communes)
                        @foreach ($communes as $commune)
                        <option
                        @if ($commune->code == $realty->commune_code) selected @endif
                        value="{{$commune->code}}">{{$commune->name_with_type}}</option>
                        @endforeach
                        @endisset
                    </select>
                    @error('commune')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">

            <div class="row">
                <div class="col-md-8 col-sm-12 select-ward-fav">
                    <select class="form-control address_input" id="project" name="project">
                        <option value="">Dự án trong khu vực</option>
                        @isset($projects)
                        @foreach ($projects as $project)
                        <option
                        @if ($project->id == $realty->project_id) selected @endif
                        value="{{$project->id}}">{{$project->name}}</option>
                        @endforeach
                        @endisset
                    </select>
                    @error('project')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-sm-4 mb-3 mb-md-0">
                    <input name="apartment_number" value="{{$realty->apartment_number ?? ''}}" id="apartment-number" class="form-control" type="text" placeholder="Số nhà">
                </div>
                <div class="col-sm-8 mb-3 mb-md-0">
                    <input name="street" value="{{$realty->street ?? old('street')}}" id="street" class="form-control address_input" type="text" placeholder="Địa chỉ cụ thể" autocomplete="off">
                    @error('street')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

    </div>
</div>
<div class="row col-upload">

    <div class="col-12">
        <div class="form-group">
            <label class="control-label">
                <span class="text">Hình ảnh nhà</span> (upload tối thiểu 2 hình, kéo thả file hoặc chọn trực tiếp từ máy tính , Dung lượng từ 600kb - &gt;1Mb kích thước tối thiểu đối với ảnh ngang 1714x968, ảnh đứng 968x1714) <strong class="text-danger">*</strong>
            </label>
            @include('components.dropzone_upload', [
                'input_name' => 'house_image',
                'mock_file' => $house_image ?? null,

            ])
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="control-label">
                <span class="text">Bản vẽ / Sổ </span> (upload tối thiểu 4 hình, kéo thả file hoặc chọn trực tiếp từ máy tính, Dung lượng từ 600kb -> 1Mb kích thước tối thiểu đối với ảnh ngang 1714x968, ảnh đứng 968x1714) <strong class="text-danger">*</strong>
            </label>
            @include('components.dropzone_upload', [
                'input_name' => 'house_design_image',
                'mock_file' => $house_design_image ?? null,

            ])
        </div>
    </div>
    <div class="map-container col-12" style="padding:20px">
        <div id="map" style="width: 100%; height:500px"></div>
    </div>
    <input type="hidden" name="google_map_lat">
    <input type="hidden" name="google_map_lng">

</div>
<div class="row">
    <div class="col-md-12">
        <label class="control-label"> <span class="text">Mô tả</span> </label>
        <div class="hidden-feedback-icon">
            <textarea name="description" id="description" class="form-control text-description" placeholder="" rows="4">{{$realty_post->description ?? old('description')}}</textarea>
        </div>
        @error('description')
        <div class="text-danger">
            {{$message}}
        </div>
        @enderror
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Thông tin liên hệ<span class="text-danger">*</span></label>
            <div class="row">
                <div class="col-md-6 col-sm-4 mb-3 mb-md-0">
                    <input id="contact_name" type="text" name="contact_name" class="form-control" placeholder="Họ tên"
                    value="{{$realty_post->contact_name ?? old('contact_name') ?? auth()->user()->name ?? ''}}" >
                    @error('contact_name')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-6 col-sm-4 ">
                    <input id="contact_phone_number" type="text" name="contact_phone_number" class="form-control" placeholder="Số điện thoại" value="{{$realty_post->contact_phone_number ?? old('contact_phone_number') ?? auth()->user()->phone_number ?? ''}}" >
                    @error('contact_phone_number')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <input id="contact_email" type="text" name="contact_email" class="form-control" placeholder="Email"
                    value="{{$realty_post->contact_email ?? old('contact_email')  ?? auth()->user()->email ?? ''}}" >
                    @error('contact_email')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Địa chỉ liên hệ<span class="text-danger">*</span></label>
            <div class="row">
                <div class="col-md-12">
                    <input id="contact_address" type="text" name="contact_address" class="form-control" placeholder="Nhập địa chỉ"
                    value="{{$realty_post->contact_address ?? old('contact_address')  ?? auth()->user()->address ?? ''}}" >
                    @error('contact_address')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <label class="">Lịch đăng tin</label>
                    @php
                        $realty_post_rank = $realty_post->rank ?? 0;
                    @endphp
                    <select class="form-control" id="realty_post_rank" name="realty_post_rank" @isset($realty_post) disabled @endisset>
                    @foreach ($post_ranks as $item)
                    <option @if($realty_post_rank == $item->rank_code) selected @endif
                        value="{{$item->rank_code}}"
                        data-price="{{$item->price ?? 100000}}"
                    >{{$item->name}}</option>
                    @endforeach
                    </select>
                    @error('realty_post_rank')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 ">
                    <label class="">Ngày bắt đầu</label>
                    <input
                    id="open_at"
                    class="date-picker form-control"
                    type="text"
                    name="open_at"
                    @isset($realty_post)
                    disabled
                    @endisset
                    @isset($realty_post->open_at)
                    value="{{Carbon\Carbon::parse($realty_post->open_at)->format('d/m/Y')}}"
                    @else
                    value="{{Carbon\Carbon::now()->format('d/m/Y')}}"
                    @endisset
                    >
                    @error('open_at')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 ">
                    <label class="">Ngày kết thúc</label>
                    <input
                    id="close_at"
                    class="date-picker form-control"
                    type="text"
                    name="close_at"
                    @isset($realty_post)
                    disabled
                    @endisset
                    @isset($realty_post->open_at)
                    value="{{Carbon\Carbon::parse($realty_post->close_at)->format('d/m/Y')}}"
                    @else
                    value="{{Carbon\Carbon::now()->addMonthsNoOverflow(1)->format('d/m/Y')}}"
                    @endisset
                    >
                    @error('close_at')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="">
                @foreach ($post_ranks as $item)
                <div class="post-rank-description" data-rank-code="{{$item->rank_code}}" style="display:none">
                    {!! $item->name ?? ''!!}
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-6">Đơn giá cuối cùng: <strong class="post-rank-price"> </strong></div>
                <div class="col-md-6">Số ngày: <strong class="post-duration"> </strong></div>
            </div>
        </div>
        <div class="form-group">
            Phí đăng tin: <strong class="post-total"></strong>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="bl-checkbox bl-checkbox-special">
                <input type="checkbox" id="require-post" class="require-post" name="requirePost" value="1">
                <label class="label_active" for="require-post">&nbsp;</label>
                <span id="require-post-text"> Tôi đồng ý với <a href="javascript:;" data-toggle="modal" data-target="#popup-require-post"> điều khoản sử dụng</a> và <span id="price-button"><a href="javasript:;" data-toggle="modal" data-target="#popup-require-price-buy">biểu phí giao dịch</a></span> </span>
            </div>
        </div>
        <div class="form-group form-button">
            <button id="btnSendNoLogin" type="submit" class="btn btn-success btn-send-no-login">Gửi Thông Tin</button>
        </div>
    </div>
</div>
@section('script')
@parent
<script src="{{asset('plugins/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('plugins/jquery-validation/dist/additional-methods.min.js')}}"></script>

<script src="{{asset('template/AdminLTE/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/AdminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script defer
    src="https://maps.googleapis.com/maps/api/js?key={{config('api_keys.google_map')}}&callback=initMap">
</script>
<script src="{{asset('template/dropzone-5.7.0/dist/dropzone.js')}}"></script>
<script>
    console.log($("#realty-post-form"));
    $("#realty-post-form").validate({
        messages: {
            title: {
                required: 'Tiêu đề không được để trống!'
            },
            area: {
                required: "Diện tích không được để trống"
            },
            direction: {
                required: "Hướng không được để trống"
            },
            price: {
                required: "Giá không được để trống"
            },
            province: {
                required: "Tỉnh thành không được để trống"
            },
            district: {
                required: "Huyện không được để trống"
            },
            commune: {
                required: "Xã không được để trống"
            },
            street: {
                required: "Địa chỉ cụ thể không được để trống",
            },
            description: {
                required: "Mô tả không được để trống"
            },
            contact_name: {
                required: "Tên liên hệ không được để trống",
            },
            contact_phone_number: {
                required: "Số điện thoại liên hệ không được để trống",
            },
            contact_email: {
                required: "Email liên hệ không được để trống",
            },
            contact_address: {
                required: "Địa chỉ liên hệ không được để trống",
            },
        },
        rules: {
            title: {
                required: true
            },
            area: {
                required: true
            },
            direction: {
                required: true
            },
            price: {
                required: true
            },
            province: {
                required: true
            },
            district: {
                required: true
            },
            commune: {
                required: true
            },
            street: {
                required: true
            },
            description: {
                required: true
            },
            contact_name: {
                required: true
            },
            contact_phone_number: {
                required: true
            },
            contact_email: {
                required: true
            },
            contact_address: {
                required: true
            },
        },
    });

    async function getPlace(url) {
        let data = await fetch(url).then(res => res.json());
        return data;
    }

    function getFullAddress(){
        $address = $('[name="street"]').val() + ',' + $('#commune option:selected').text() + ',' + $('#district option:selected').text() + ',' + $('#province option:selected').text();

        return $address;
    }

    function initMap() {
        // The location of Uluru
        @isset($realty)
            var current = {
                lat: {{$realty->google_map_lat ?? 21.027964}},
                lng: {{$realty->google_map_lng ?? 105.8510132}},
            };
            @else
            var current = {
                lat:  21.027964,
                lng: 105.8510132
            };
        @endisset
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), { zoom: 17, center: current, optimized: true });
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({
            position: current,
            map: map,
            draggable: true,
        });
        map.addListener('mouseout', function () {
            console.log(marker.getPosition().toString());
            $('[name="google_map_lat"]').val(marker.getPosition().lat());
            $('[name="google_map_lng"]').val(marker.getPosition().lng());
        });

        $('.address_input').on('blur', function(e){
            var address = getFullAddress();
            console.log(address);
            changeMarker(address);
        })

        function changeMarker(address){
            let link = `/get-geo-by-name?search_string=${address}`
            getPlace(link).then(data => {
                geo = data.results[0].geometry.location;
                marker.setPosition( new google.maps.LatLng( geo.lat, geo.lng ) );
                map.panTo( new google.maps.LatLng( geo.lat, geo.lng ));
                $('[name="google_map_lat"]').val(geo.lat);
                $('[name="google_map_lng"]').val(geo.lng);
            });
        }
    }
    Dropzone.autoDiscover = false;
    $( document ).ready(function() {
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

        function getProject(district_code){
            url = '/get-project-of-district/' + district_code;
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

            var project_inputs = '<option value="">Dự án trong khu vực</option>'
            getProject(district_code)
            .done(function(data){
                data.forEach(element => {
                    project_inputs += `<option data-name="${element.name}" data-street="${element.street}" data-commune-code="${element.commune_code}" value="${element.id}">${element.name}</option>`;
                });
                $('#project').html(project_inputs);
            })
        })

    });

    $(document).on('change', '#project', function(){

        var project = $(this).find('option:selected');
        var commune_code = project.data('commune-code');
        var street = project.data('street');

        $(`#commune`).val([]);
        $(`#commune option[value=${commune_code}]`).prop('selected',true);
        if (street) {
            $('#street').val(project.data('name') + ', ' +  street);
        }
    });

    $(document).on('change', '#commune', function(){
        $(`#project`).val('');
    });

    $('.date-picker').each(function(){
        $(this).daterangepicker({
            singleDatePicker: true,
            timePicker24Hour: true,
            locale: {
                "format": 'DD/MM/YYYY',
                "applyLabel": "Ok",
                "cancelLabel": "Thoát",
                "fromLabel": "Từ",
                "toLabel": "Đến",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "CN",
                    "T2",
                    "T3",
                    "T4",
                    "T5",
                    "T6",
                    "T7"
                ],
                "monthNames": [
                    "Tháng 1",
                    "Tháng 2",
                    "Tháng 3",
                    "Tháng 4",
                    "Tháng 5",
                    "Tháng 6",
                    "Tháng 7",
                    "Tháng 8",
                    "Tháng 9",
                    "Tháng 10",
                    "Tháng 11",
                    "Tháng 12"
                ],
            },
        })
    })

    function showPostRankDetails(){
        var post_rank =  $('#realty_post_rank').val();
        var post_rank_price =  $('#realty_post_rank option:selected').data('price');

        var open_at =new Date($('#open_at').val().split('/').reverse().join('-')) ;
        var close_at = new Date($('#close_at').val().split('/').reverse().join('-')) ;
        var duration = close_at - open_at;

        $('.post-rank-price').text(Math.round(post_rank_price / 1000) + ' nghìn/Ngày');
        $('.post-duration').text(Math.round(duration / 86400000) + ' ngày');

        var total = Math.round(post_rank_price * duration / 86400000);
        if (total > 1000000) {
            var total_string = Math.floor(total / 1000000) + ' triệu ' + Math.floor(total % 1000000 / 1000) + ' nghìn';
        } else {
            var total_string = Math.floor(total % 1000000 / 1000) + ' nghìn';
        }

        $('.post-total').text(total_string);
    }

    showPostRankDetails();

    $('#realty_post_rank').on('change', function(){
        var rank_code = $(this).val();
        console.log($(`post-rank-description[data-rank-code="${rank_code}"]`));
        $('.post-rank-description').hide();
        $(`.post-rank-description[data-rank-code="${rank_code}"]`).show();

        showPostRankDetails();
    });
    $('#open_at').on('change', function(){
        showPostRankDetails()
    });
    $('#close_at').on('change', function(){
        showPostRankDetails()
    });


    $('[name=realty_post_type]').on('change', function(){
        var realtyTypeList = $('[name=realty_post_type]:checked').data('realty-type');
        var list = realtyTypeList.split(',');
        $('.realty-type-item').each(function(){
           if (list.includes(this.value)) {
                this.style.display = 'block';
           }else{
                this.style.display = 'none';
           }
        })
    })
    $('[name=realty_post_type]').trigger('change');

    $('#price').on('input', function(){
        var price = $(this).val();
        var word = num2Word2.convert(price);
        $('.price_word em').text(word);
    })
    $('#price').trigger('input');
</script>
@endsection

@section('css')
@parent
    <link rel="stylesheet" href="{{asset('template/dropzone-5.7.0/dist/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/daterangepicker/daterangepicker.css')}}">
@endsection
