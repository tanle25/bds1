<?php

namespace App\Services;

use Str;

class SlugService
{
    public $model;

    public function __construct()
    {

    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getSlug($string)
    {
        $is_exsist = true;
        $i = 1;
        $base_slug = Str::slug($string);
        $slug = $base_slug;
        while ($is_exsist == true) {
            $instance = $this->model::where('slug', $slug)->first();
            if (!$instance) {
                break;
            }
            $i++;
            if ($i >= 1) {
                $slug = $base_slug . '-' . $i;
            }
        }
        return $slug;
    }

    public function isExsist($string)
    {
        $slug = Str::slug($string);
        $instance = $this->model::where('slug', $slug)->first();
        if (!$instance) {
            return false;
        };
        return true;
    }
}