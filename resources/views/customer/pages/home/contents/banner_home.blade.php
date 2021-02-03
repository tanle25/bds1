@php
    $banners = explode(',', $theme_options['Banner'] ?? '');
    $banner_mobile = explode(',', $theme_options['Banner_mobile'] ?? '');
@endphp

@section('css')
    @parent
    <style>
        .hidden-field{
            display:none;
        }

        .search-input{
            position: relative;
        }
        .search-input > i{
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            font-size: 1.2em;
            z-index: 1000;
            color: rgb(87, 87, 87)
        }
    </style>
@endsection
<section class="banner-home">
    @if (Agent::isMobile())
    <div class="banner-home-slider owl-carousel">
            @foreach ($banner_mobile as $item)
                @if ($item)
                    <div class="item img-responsive">
                        <img class="lazy" data-src="{{$item}}" alt=""  srcset="">
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="banner-home-slider owl-carousel" style="z-index: 1">
            @foreach ($banners as $item)
                @if ($item)
                    <div class="item embed-responsive embed-responsive-19by4 w-100 banner-item">
                        <img data-src="{{$item}}" class="lazy embed-responsive-item" alt="" style="height: 100%; object-fit:cover" srcset="">
                    </div>
                @endif
            @endforeach
        </div>
    @endif

	<div class="container mx-auto px-0 position-relative" style="margin-top: -72px; z-index:2">
		<div class="section-filter-home d-none d-md-block">
            <form action="" id="form-search">
                <div class="search-type d-flex">

                    <div class="search-type-item mr-1">
                        <input type="radio"  class="d-none" name="loai-tin-dang" value="1" id="realty-sell">
                        <label class="py-2 px-4 font-9 m-0 rounded-top" for="realty-sell"><strong>NHÀ ĐẤT BÁN</strong></label>
                    </div>
                    <div class="search-type-item">
                        <input class="d-none" type="radio" name="loai-tin-dang" checked value="2" id="realty-rent">
                        <label class="py-2 px-4 m-0 font-9 rounded-top" for="realty-rent"><strong>NHÀ ĐẤT CHO THUÊ</strong></label>
                    </div>
                </div>
                <div class="search-field p-2 ">
                    <div class="pt-2">
                        <div class="search-field-header bg-white d-md-flex align-items-center mx-2">
                            <div class="search-input d-md-flex  align-items-center" style="flex: 0 0 calc(20%)">
                                {{-- <i class="d-block fa fa-address-book" aria-hidden="true"></i> --}}
                                <i class="fal fa-car-building"></i>
                                <select class="realty-type form-control border-0 select2 border-0" name="loai-bds">
                                    <option data-realty-post-type="1" value="">Loại nhà đất</option>
                                    <option data-realty-post-type="2" value="">Loại nhà đất</option>
                                    @foreach (config('constant.realty_post_type') as $type =>  $item)
                                        @foreach ($item['realty_type_list'] as  $realty_type)
                                            <option data-slug="{{config('constant.realty_type.'.$realty_type)['slug']}}" data-realty-post-type="{{$type}}" value="{{$realty_type}}">{{config('constant.realty_type.'.$realty_type)['name']}}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="address-input search-input input-group">
                                <i class="far fa-search "></i>
                                <input type="text" class="form-control pl-5 rounded-0" name="dia-chi" placeholder="Tìm kiếm bất động sản" >
                            </div>
                            <button style="width:" id="apply-search" type="button" style="flex: 0 0 calc(20%)" class="d-none d-md-block font-weight-500 text-light btn btn-warning rounded-0">Tìm kiếm</button>
                        </div>
                    </div>

                    <div class="search-criteria d-flex mt-2">
                        <div class="form-group mb-2 py-2 search-input pl-2 pr-1">
                            <i class="fal fa-map-marked-alt ml-2"></i>
                            <select class="border form-control select2 select2-info" id="province" name="tinh" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="">Tỉnh / Thành phố</option>
                                @foreach ($provinces as $province)
                                    <option data-slug="{{$province->slug}}" value="{{$province->code}}">{{$province->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2 py-2 search-input px-2 ">
                            <i class="fal fa-usd-circle ml-2"></i>
                            <select class="form-control select2 select2-info realty-price"  name="gia" data-dropdown-css-class="select2-info" style="width: 100%;">
                                @php
                                    function beautyPrice($price){
                                        if($price >= 1000){
                                            return $price / 1000 . ' tỉ';
                                        }elseif($price > 0){
                                            return $price . ' triệu';
                                        }else{
                                            return $price;
                                        }
                                    }
                                @endphp

                                @foreach (config('constant.realty_post_type') as $type_id => $realty_post_type)
                                    <option value="">Giá</option>
                                    @foreach ($list = $realty_post_type['price_range'] as $index => $range)
                                        @if ($index < count($list) - 1 )
                                            <option data-realty-post-type="{{$type_id}}"  name="gia" value="{{$list[$index] *1000000}},{{$list[$index + 1] * 1000000}}">{{beautyPrice($list[$index])}} - {{beautyPrice($list[$index + 1])}}</option>
                                        @else
                                            <option data-realty-post-type="{{$type_id}}" name="gia" value="{{$list[$index] *1000000}},10000000000000">Trên {{beautyPrice($list[$index])}}</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 py-2 search-input px-2 ">
                            <i class="far fa-vector-square ml-2"></i>

                            <select class="form-control select2 select2-info" value="" name="dien-tich" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="">Diện tích</option>
                                @foreach ($list =  config('constant.realty_area_range') as $index => $item)
                                <li>
                                    @if ($index < count($list) - 1 )
                                    <option value="{{$item}},{{$list[$index + 1]}}">{{$item}} m2 - {{$list[$index + 1]}} m2</option>
                                    @else
                                    <option value="{{$item}},10000">Trên {{$item}} m2</option>
                                    @endif
                                    </span></label>
                                </li>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 py-2 search-input px-2 ">
                            <i class="fal fa-compass ml-2"></i>
                            <select class="form-control select2 select2-info" value="" name="huong" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Hướng</option>
                                @foreach (config('constant.direction') as $index => $item)
                                    <option value="{{$index}}" >{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="hidden-field form-group mb-2 py-2 search-input px-2 ">

                        </div>
                        <div class="hidden-field form-group mb-2 py-2 search-input pl-2 pr-1">
                            <i class="fal fa-route ml-2"></i>
                            <select class="form-control select2 select2-info" value="" id="district" name="huyen" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Quận / Huyện</option>

                            </select>
                        </div>
                        <div class="hidden-field form-group mb-2 py-2 search-input px-2 ">
                            <i class="fal fa-route ml-2"></i>
                            <select class="form-control select2 select2-info" value="" id="commune" name="xa" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Phường / xã</option>
                            </select>
                        </div>
                        <div class="hidden-field form-group mb-2 py-2 search-input px-2 ">
                            <i class="fal fa-building ml-2"></i>
                            <select class="form-control select2 select2-info" id="" value="" name="du-an" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Dự án</option>
                            </select>
                        </div>
                        <div class="hidden-field px-2  form-group mb-2 py-2 search-input">

                        </div>
                        <div class="px-2  mb-2 py-2 search-input d-flex align-items-center" >
                            <div class="bg-white closed btn-expand-search w-100 btn rounded-0 text-left border font-9">
                                <i class="far fa-chevron-down"></i>
                                Thêm
                            </div>
                        </div>
                        <button id="apply-search" type="button" class=" d-block d-md-none btn btn-info px-5 mx-auto rounded">Tìm kiếm</button>
                    </div>
                </div>
            </form>
		</div>
	</div>
</section>

@section('script')
	@parent
	<script>

        $('.btn-expand-search').on('click', function(){
            $('.hidden-field').toggle();
            if ($(this).hasClass('closed')) {
                console.log('hello');
                $(this).removeClass('closed');
                $(this).addClass('opened');
                $(this).html(`
                <i class="far fa-chevron-up"></i> Ẩn
                `);
            }else if ($(this).hasClass('opened')) {
                $(this).removeClass('opened');
                $(this).addClass('closed');
                $(this).html(`
                <i class="far fa-chevron-down"></i> Thêm
                `);
            }

        })

        $("[name=loai-tin-dang]").on('change', function(){
            $postType = $(this).val();
            $(`.realty-type option`).prop('disabled', true);
            $(`.realty-type option[data-realty-post-type=${$postType}]`).prop('disabled', false);

            $(`.realty-price option`).prop('disabled', true);
            $(`.realty-price option[data-realty-post-type=${$postType}]`).prop('disabled', false);
        })


        function getDistricts(province_code) {
            url = '/get-district-of-province/' + province_code;
            return $.ajax({
                url: url,
                type: 'get',
            })
        }

        $('#province').on('change', function () {
            var province_code = $(this).val();
            var district_inputs = `<option value="" selected>Quận / huyện</option>`;
            getDistricts(province_code)
                .done(function (data) {
                    data.forEach(element => {
                        district_inputs += `<option data-slug="${element.slug}" value="${element.code}" >${element.name_with_type}</option>`
                    });
                    $('#district').html(district_inputs);
                });
        })

        function getCommunes(district_code) {
            url = '/get-commune-of-district/' + district_code;
            return $.ajax({
                url: url,
                type: 'get',
            })
        }

        $(document).on('change', "[name='huyen']", function () {
            var district_code = $(this).val();
            var commune_inputs = `<option value="" selected>Phường / xã</option>`;
            getCommunes(district_code)
                .done(function (data) {
                    data.forEach(element => {
                        commune_inputs += `<option data-slug="${element.slug}" value="${element.code}" >${element.name_with_type}</option>`
                    });
                    $('#commune').html(commune_inputs);
                });
        })


        function getQuery() {
            var data = $('#form-search').serializeArray();
            var result = {};
            data.forEach(function (item) {
                if (result[item.name]) {
                    result[item.name] += ',' + item.value;
                } else {
                    result[item.name] = item.value;
                }
            });

            var query = '/tim-kiem?';
            var queryElem = [];
            if (result['loai-tin-dang']) {
                queryElem.push( result['loai-tin-dang'] == 2 ? 'cho-thue' : 'ban' )
            }

            if (result['loai-bds']) {
                var realtyTypeSlug = $('.realty-type option:selected').data('slug');
                queryElem.push(realtyTypeSlug);
            }

            if (result['xa']){
                var realtyTypeSlug = $('#commune option:selected').data('slug');
                queryElem.push(realtyTypeSlug);
            }else if(result['huyen']){
                var realtyTypeSlug = $('#district option:selected').data('slug');
                queryElem.push(realtyTypeSlug)
            }else if(result['tinh']){
                var realtyTypeSlug = $('#province option:selected').data('slug');
                queryElem.push(realtyTypeSlug)
            }
            var slug = '/' + queryElem.join('-') + '?';
            var query = '';
            var validParam = ['dien-tich', 'du-an', 'huong', 'gia', 'dia-chi']
            Object.entries(result).forEach(function (item, index) {
                if (validParam.includes(item[0])) {
                    if (query === '' && item[1] != '') {
                        query += item[0] + '=' + item[1];
                        return
                    };

                    if (query !== '' && item[1] != '') {
                        query += '&' + item[0] + '=' + item[1];
                        return
                    }
                }
            });
            window.location = slug + query ;
        }
        $(document).on('click', '#apply-search', function () {
            getQuery();
        })

        $('.ms-search').on('click', function(e){
            e.stopPropagation();
        })

        $('.search-type label').on('click', function(){
            var type = $(this).data('value');
            $('.price_range input').prop('checked', false);
            $('.price_range').hide();
            $(`.price_range[data-value=${type}]`).show();
        })
        $('.search-type label:first').trigger('click');

        $('.banner-home-slider').owlCarousel({
        loop:true,
        autoplay: true,
        autoplayHoverPause:true,
        dots:false,
        nav:true,
        navText:["<div class='owl-nav-btn banner-nav prev-slide'><i class='fas fa-chevron-left'></i></div>","<div class='owl-nav-btn next-slide banner-nav'><i class='fas fa-chevron-right'></i></div>"],
        autoplayTimeout:10000,
        autoplaySpeed:1000,
        smartSpeed:1000,
        animateOut: 'fadeOut',
        responsive:{
            0:{
                items:1,
            },
        }

    });
    </script>

@endsection
