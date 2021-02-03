@section('css')
@parent
<style>
    .sidebar-post-link{
        color: #222d44;
        font-weight: 600;
    }
</style>
@endsection

    {{-- Chuyên mục được yêu thích --}}
    @isset($featured_realties)
        <div class="rounded-1 bg-white p-3 mb-3" >
            <h4 class="uppercase font-w-600">Nhà đất nổi bật</h4>
            <div class="row px-2">
                @foreach ($featured_realties as $item)
                <div class="col-6 p-2">
                    <a href="{{$item->link}}" class="d-block position-relative img-wraper">
                        <img src="{{$item->thumb}}" style="height: 130px" alt="{{$item->name}}">
                        <div class="ribbon-wrapper ribbon">
                          <div class="ribbon bg-danger text-white">
                            HOT
                          </div>
                        </div>
                    </a>
                    <a class="d-block line-height-12 mt-2 text-secondary font-9" href="{{$item->link}}">{{Str::limit($item->title, 35, ' ...')}}</a>
                </div>
                @endforeach
            </div>
        </div>
    @endisset

    @isset($featured_districts)
    <div class="rounded-1 bg-white p-3 mb-3 border-bottom" >
        <h4 class="uppercase font-w-600">Mua bán nhà đất tại {{config('constant.province_name') ?? 'Thanh Hóa'}}</h4>
        <div class="row">
            @foreach ($featured_districts as $district)
            <div class="col-sm-6 py-1">
                <a class="cl-light-blue font-9" href="/{{$district->slug ?? ''}}">{{$district->name}}</a>
                <span class="font-9">({{$district->realty_posts_count}})</span>
            </div>
            @endforeach
        </div>
    </div>
    @endisset

    {{-- Chuyên mục được yêu thích --}}
    <div class="rounded-1 bg-white p-3 mb-3" >
        <h4 class="uppercase font-w-600">Chủ đề được yêu thích</h4>
        @isset($featured_tags)
        @foreach ($featured_tags as $tag)
        <a href="{{route('customer.realty_tag.get_all', $tag->slug)}}" class="d-inline-block py-1 px-2 my-2 mr-2 hrm-btn-info-solid">
            <strong class="font-9">#{{$tag->name}}</strong>
        </a>
        @endforeach
        @endisset
    </div>


    {{-- Chuyên mục được yêu thích --}}
    @isset($featured_posts)
    <div class="rounded-1 bg-white p-3 mb-3 border-bottom" >
        <h4 class="font-w-600 uppercase">Tin hay cho bạn</h4>
        @foreach ($featured_posts->skip(5)->take(5) ?? [] as $item)
        <div class="d-flex py-3 border-top">
            <a class="flex-fixed-width rounded-1 mr-3" href="{{route('customer.post.show',['cat_slug' => $item->categories->first()->slug ?? 'danh-muc', 'post_slug' => $item->slug] )}}" class="rounded-1" style="width: 125px">
                <img style="width: 100px; height:70px" src="{{$item->thumb}}" alt="{{$item->name}}">
            </a>
            <div>
                <a class="font-10 sidebar-link text-secondary" href="{{route('customer.post.show',['cat_slug' => $item->categories->first()->slug ?? 'danh-muc', 'post_slug' => $item->slug] )}}"> {{$item->name}} </a>
            </div>
        </div>
        @endforeach
    </div>
    @endisset

@section('script')
@parent
<script>
    $('.sidebar-link').each(function(){
        maxText($(this), 50);
    })
</script>
@endsection
