<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Province;
use App\Models\Realty;
use App\Models\RealtyPost;
use App\Scraper\PostScraper;
use App\Scraper\RealtyScraper;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CrawController extends Controller
{
    public function __construct(PostScraper $post_scraper, RealtyScraper $realty_scraper)
    {
        $this->post_scraper = $post_scraper;
        $this->realty_scraper = $realty_scraper;

    }

    public function showCrawForm()
    {
        $categories = PostCategory::all();
        return view('admin.pages.posts.craw', compact("categories"));
    }

    public function getByLink(Request $request)
    {
        if ($request->has('link')) {
            $post = $this->post_scraper->scrapePost($request->link);
            try {
                DB::beginTransaction();
                if ($request->has('avatar')) {
                    $post['avatar'] = $request->avatar;
                }
                $post = Post::create($post);
                DB::commit();
                if ($request->has('categories')) {
                    $this->updateCategory($post->id, $request->categories);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
                return back()->with('error', 'Tải bài viết không thành công vui lòng kiểm tra lại đường dẫn!');
            }

            return redirect()->back()->with('success', 'Tạo mới thành công bài viết');
        }

    }

    private function updateCategory($post_id, $categories)
    {

        DB::table('post_to_category')->where('post_id', $post_id)->delete();
        foreach ($categories as $category) {
            DB::table('post_to_category')->insert([
                'post_id' => $post_id,
                'category_id' => $category,
            ]);
        }
    }

    // realty craw
    public function getRealtyForm()
    {
        if (!empty(config('constant.provinces'))) {
            $provinces = Province::whereIn('code', config('constant.provinces'))->get();
        } else {
            $provinces = Province::orderBy('slug')->get();
        }

        return view('admin.pages.realty_post.craw', compact('provinces'));
    }

    public function getRealty(Request $request)
    {
        $string_now = Carbon::now()->format('d/m/Y');

        $request->validate([
            'link' => "required",
            'province' => 'required|numeric',
            'district' => 'required|numeric',
            'commune' => 'required|numeric',

            'contact_name' => 'required|string|max:256',
            'contact_phone_number' => 'required|string|max:30',
            'contact_email' => 'required|email|string|max:30',
            'contact_address' => 'max:300',

            'close_at' => 'date_format:d/m/Y|after:open_at',
            'open_at' => 'date_format:d/m/Y|after:' . $string_now,
        ]);

        $new_realty = [
            'province_code' => $request->province,
            'district_code' => $request->district,
            'commune_code' => $request->commune,
        ];

        $open_at = Carbon::createFromFormat('d/m/Y', $request->open_at);
        $close_at = Carbon::createFromFormat('d/m/Y', $request->close_at);
        $new_realty_post = [
            'open_at' => $open_at->format('Y-m-d H:i:s'),
            'close_at' => $close_at->format('Y-m-d H:i:s'),
            "status" => $request->status ?? "1",
            'contact_name' => $request->contact_name,
            'contact_phone_number' => $request->contact_phone_number,
            'contact_email' => $request->contact_email,
            'contact_address' => $request->contact_address,
            'rank' => $request->realty_post_rank,
        ];

        if ($request->has('link')) {
            $result = $this->realty_scraper->crawList($request->link);
            foreach ($result as $item) {
                $realty_temp = array_merge($item['realty'], $new_realty);
                $realty_post_temp = array_merge($item['realty_post'], $new_realty_post);
                try {
                    DB::beginTransaction();
                    $new_realty_stored = Realty::create($realty_temp);
                    $realty_post_temp['realty_id'] = $new_realty_stored->id;
                    RealtyPost::create($realty_post_temp);
                    DB::commit();
                } catch (\Exception $e) {

                    DB::rollback();
                    return $e->getMessage();
                    continue;
                }
            }

            return redirect()->back()->with('success', 'Tạo mới thành công bất động sản');
        }

    }

}