<div class="p-3 rounded bg-white border">
    <h3 class="font-12 py-2 border-bottom">
        Nhà đất tại {{config('constant.province_name') ?? 'Thanh Hóa'}}
    </h3>
    <div class="">
        @foreach ($districts as $item)
            <a class="d-block secondary-text py-1 font-9" href="/{{$item->slug}}">{{$item->name_with_type}} ({{$item->realty_posts_count}})</a>
        @endforeach
    </div>
</div>

{{-- Chuyên mục được yêu thích --}}
@isset($featured_posts)
<div class="rounded  p-3 my-3 border bg-white" >
    <h3 class="font-12 py-2 border-bottom uppercase">Tin xem nhiều nhất</h3>
    @foreach ($featured_posts->take(5) as $item)
    <div class="">
        <a class=" d-inline-block py-2 font-9 sidebar-post-link secondary-text" href="{{route('customer.post.show',['cat_slug' => $item->categories->first()->slug ?? 'danh-muc', 'post_slug' => $item->slug] )}}"> {{$item->name}} </a>
    </div>
    @endforeach
</div>
@endisset

@section('script')
    @parent
    <script>
        $('.sidebar-post-link').each(function(){
            maxText($(this), 60);
        })
    </script>
@endsection
