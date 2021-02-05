<?php

namespace App\Providers;

use App\Models\ThemeOption;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use View;

class SpaProvider extends ServiceProvider
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
        if (Schema::hasTable('theme_options')) {
            $list = ThemeOption::all();
            $theme_options = [];
            foreach ($list as $item) {
                $theme_options[$item->key] = $item->value;
            };

            View::composer(
                ['app.main'], function ($view) use ($theme_options) {
                    $view->with('theme_options', $theme_options);
                }
            );
        }
    }
}