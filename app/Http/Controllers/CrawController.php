<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Scraper\PostScraper;
use DB;
use Illuminate\Http\Request;

class CrawController extends Controller
{
    public function __construct(PostScraper $post_scraper)
    {
        $this->post_scraper = $post_scraper;
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
}