<div class="block-realty">
    <div class="realty-container shadow-6 flex-wrap rounded d-flex d-md-block">
        <div class="overflow-hidden col-5 px-0 col-md-12 order-2 bg-white position-relative">
            <a href="{{$item->link}}"class="d-block ml-2 ml-md-0 img-wraper height-md-180 height-120">
                <img class="lazy" data-src="{{$item->thumb}}" alt="" srcset="">
            </a>
            @php
                $is_featured = false;
                if (Auth::user()) {
                    if($item->featured_by->contains('id', Auth::user()->id)){
                        $is_featured = true;
                    }
                }
            @endphp
            @if ($is_featured)
                <div data-post-id="{{$item->id ?? 1}}" class="btnlike like-heart checked">
                    <i class="fas fa-heart text-danger font-14"></i>
                </div>
            @else
                <div data-post-id="{{$item->id ?? 1}}" class="btnlike like-heart unchecked">
                    <i class="far fa-heart text-white font-14"></i>
                </div>
            @endif

            @if ($item->rank == 4)
                <div class="hrm-ribbon-danger font-9 px-3 py-1">
                    Nổi bật
                </div>
            @endif
            @if ($item->rank == 3)
                <div class="hrm-ribbon-primary font-9 px-3 py-1">
                    Vip
                </div>
            @endif
        </div>
        <div class="order-1 col-12 bg-white px-3 pt-2 pb-2 pb-md-0">
            <a href="{{$item->link}}" class="d-block font-9 main-text w-100 hrm-truncate
                @if ($item->rank == 4)
                text-danger
                @endif
                @if ($item->rank == 3)
                text-info
                @endif
                " style="font-weight: 500; max-height: 3em; line-height: 1.5em"
                >{{$item->title}}
            </a>
        </div>
        <div class="realty-body col-7 col-md-12  bg-white order-3 px-3 pb-1">
            <span class="font-weight-500 font-9">
                @if ($item->price_type !== 0)
                {{ \App\Helpers\CurrencyHelper::beautyPrice($item->price)}}
                @endif
                {{config('constant.price_type.'. $item->price_type)['front_view']}}
            </span>
            <div class="row">

                <div class="col-6 mb-2 mt-1  ">
                    <i class="far fa-expand pr-1"></i>
                    <span class="font-9">{{$item->realty->area ?? ''}}m²</span>
                </div>
                <span class="col-6 mb-2 mt-1">
                    <i class="fal fa-compass pr-1"></i>
                    <span class="font-8">{{config('constant.direction.'. $item->realty->direction)['name'] ?? "--"}}</span>
                </span>
                <span class="col-6 mb-2 mt-1 d-flex">
                    <i class="fal fa-car-building pr-1"></i>
                    <span class="font-8 d-block text-truncate">{{config('constant.realty_type.'. $item->realty->type)['name'] ?? "--"}}</span>
                </span>

                <span class="col-6 mb-2 mt-1 d-flex">
                    <i class="fal fa-bed pr-1"></i>
                    <span class="font-8 d-block text-truncate">{{$item->realty->number_of_bed_rooms ? $item->realty->number_of_bed_rooms . ' phòng' : "--"}}</span>
                </span>

                <span class="col-12 d-flex mt-1">
                    <i class="fal fa-map-marker-alt pr-1"></i>
                    <span class="font-8 d-block text-truncate">{{$item->realty->district->name_with_type ?? ''}}, {{$item->realty->province->name ?? ''}}</span>
                </span>
            </div>
        </div>
        <div class="realty-block-footer bg-white px-3 pb-2 d-none d-md-block">
            <div class="border-top justify-content-between d-flex py-2 my-1">
                <div class="font-8"><i class="fal fa-calendar-alt"></i> {{Carbon\Carbon::parse($item->created_at ?? '')->format('d/m/Y')}}</div>
                <div class="font-8"><i class="fal fa-eye"></i> 23</div>
            </div>
        </div>
    </div>
</div>
