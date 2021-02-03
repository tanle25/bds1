<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Partner;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\Province;
use App\Models\RealtyPost;
use App\Models\Widget;
use App\Services\ProjectService;

class HomeController extends Controller
{
    public function __construct(ProjectService $project_service)
    {
        $this->project_service = $project_service;
    }

    public function index()
    {
        $widgets = Widget::all();

        if (!empty(config('constant.provinces'))) {
            $provinces = Province::whereIn('code', config('constant.provinces'))->get();
        } else {
            $provinces = Province::orderBy('slug')->get();
        }
        $featured_district_code = $widgets->where('name', 'bds_noi_bat')->first()->data_array->districts ?? [];
        $featured_district = District::withCount('realty_posts')->whereIn('code', $featured_district_code)->get();

        $home_why_choose = $widgets->where('name', 'home_why_choose')->first()->data_array ?? [];

        $current_post_categories = $widgets->where('name', 'tin_tuc_noi_bat')->first()->data_array->post_categories ?? [];
        $home_featured_cats = PostCategory::whereIn('id', $current_post_categories)
            ->with('posts')
            ->get();
        $home_featured_post = Post::where('is_featured', 1)->with('categories')->orderByDesc('id')->take(7)->get();
        $home_projects = $widgets->where('name', 'du_an_noi_bat')->first()->data_array->projects ?? [];

        $home_projects = Project::whereIn('id', $home_projects)->with('realty_posts', 'realty_posts.realty')->take(6)->get();

        $home_projects = $this->project_service->getProjectDetails($home_projects);
        $random_realties = RealtyPost::with('realty', 'realty.district')->orderByDesc('id')->take(50)->get();
        if ($random_realties->count() >= 6) {
            $random_realties = $random_realties->random(8)->sortByDesc('rank');
        }
        $partners = Partner::where('rank', 1)->take(10)->get();
        return view('customer.pages.home.index', compact('home_why_choose', 'partners', 'random_realties', 'home_projects', 'provinces', 'featured_district', 'home_featured_cats', 'home_featured_post'));
    }
}