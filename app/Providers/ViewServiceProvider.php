<?php

namespace App\Providers;

use App\Models\Advertisment;
use App\Models\District;
use App\Models\MenuCategory;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Province;
use App\Models\RealtyPost;
use App\Models\SeoManager;
use App\Models\ThemeOption;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Tags\Tag;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        if (Schema::hasTable('theme_options')) {
            $list = ThemeOption::all();
            $theme_options = [];
            foreach ($list as $item) {
                $theme_options[$item->key] = $item->value;
            };
            View::composer(
                ['customer.main', 'mails.*', 'customer.partials.*', 'auth.*', 'customer.pages.home.contents.banner_home', 'customer.pages.contacts.*'], function ($view) use ($theme_options) {
                    $view->with('theme_options', $theme_options);
                }
            );
        }

        // Using class based composers...
        if (Schema::hasTable('provinces')) {
            if (!empty(config('constant.provinces'))) {
                $provinces = Province::whereIn('code', config('constant.provinces'))->get();
            } else {
                $provinces = Province::orderBy('slug')->get();
            }
            View::composer(
                ['customer.components.side_search', 'customer.pages.project.index', 'customer.components.search_top', 'customer.components.search.nav_search'], function ($view) use ($provinces) {
                    $view->with('provinces', $provinces);
                }
            );

        }

        if (Schema::hasTable('menu_categories')) {
            View::composer(
                ['customer.partials.header', 'customer.layouts.main'], function ($view) {
                    $menu_category = MenuCategory::with(['menus', 'menus.childs'])->where('name', 'main_menu')->first();
                    if ($menu_category) {
                        $view->with('main_menu', $menu_category->menus->where('parent_id', null)->sortBy('sort') ?? []);
                    } else {
                        $view->with('main_menu', []);
                    }
                }
            );

            View::composer(
                'customer.partials.footer', function ($view) {
                    $menu_category = MenuCategory::with(['menus', 'menus.childs'])->where('name', 'footer_v3')->first();
                    if ($menu_category) {
                        $view->with('footer_v3', $menu_category->menus->where('parent_id', null)->sortBy('sort') ?? []);
                    } else {
                        $view->with('footer_v3', []);
                    }
                }
            );
        }

        if (Schema::hasTable('posts')) {
            View::composer(
                'customer.pages.posts.sidebar', function ($view) {
                    $featured_posts = Post::orderByDesc('id')->take(10)->get();
                    $featured_districts = District::whereIn('parent_code', config('constant.provinces'))->withCount('realty_posts')->orderByDesc('realty_posts_count')->take(20)->get();
                    $featured_tags = Tag::all();
                    if ($featured_tags->count() >= 6) {
                        $featured_tags = $featured_tags->random(6);
                    } else {
                        $featured_tags = [];
                    }

                    $view->with(['featured_tags' => $featured_tags, 'featured_posts' => $featured_posts, 'featured_districts' => $featured_districts]);
                }
            );
        }

        if (Schema::hasTable('realty_posts')) {
            View::composer(
                'customer.pages.realty_post.sidebar', function ($view) {
                    $featured_posts = Post::orderByDesc('id')->take(50)->get();
                    if ($featured_posts->count() >= 6) {
                        $featured_posts = $featured_posts->random(6)->sortByDesc('rank');
                    }
                    $partners = Partner::where('rank', 1)->take(10)->get();

                    $districts = District::withCount('realty_posts')->where('parent_code', config('constant.provinces')[0] ?? 38)->get();
                    $view->with(['districts' => $districts, 'featured_posts' => $featured_posts]);
                }
            );

            View::composer(
                'customer.components.sidebars.realty_sidebar', function ($view) {
                    $featured_realties = RealtyPost::with('realty')->orderByDesc('rank')->take(6)->get();
                    $featured_districts = District::whereIn('parent_code', config('constant.provinces'))->withCount('realty_posts')->orderByDesc('realty_posts_count')->take(20)->get();
                    $featured_tags = Tag::where('type', 'realty')->get();
                    $featured_posts = Post::orderByDesc('id')->take(10)->get();
                    $view->with(['featured_realties' => $featured_realties, 'featured_tags' => $featured_tags, 'featured_posts' => $featured_posts, 'featured_districts' => $featured_districts]);
                }
            );
        }

        if (Schema::hasTable('advertisments')) {
            View::composer(
                ['customer.pages.home.index'], function ($view) {
                    $advertisments = Advertisment::where('status', 1)->get();
                    $view->with([
                        'vertical_advertisments' => $advertisments->where('type', 1),
                        'horizontal_advertisments' => $advertisments->where('type', 2),
                        'mobile_vertical_advertisments' => $advertisments->where('type', 3),
                        'mobile_horizontal_advertisments' => $advertisments->where('type', 4),
                    ]);
                }
            );
        }

        if (Schema::hasTable('seo_manager')) {
            if (request()->path() !== '/') {
                $url = '/' . request()->path();
            } else {
                $url = '/';
            }
            View::composer(
                '*', function ($view) use ($url) {
                    $seo = SeoManager::where('link', $url)->first();
                    if ($seo) {
                        $view->with('seo', $seo);
                    }
                }
            );
        }
    }
}