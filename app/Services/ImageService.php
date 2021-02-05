<?php

namespace App\Services;

use App\Models\ThemeOption;
use Illuminate\Support\Facades\Storage;
use Image;
use Str;

class ImageService
{
    private $watermark_size = 20;
    private $watermark_opacity = 70;
    private $watermark_position = 'center';

    public function __construct()
    {
        $list = ThemeOption::all();
        $theme_options = [];
        foreach ($list as $item) {
            $theme_options[$item->key] = $item->value;
        };

        if (isset($theme_options['watermark_size']) && is_numeric($theme_options['watermark_size']) && $theme_options['watermark_size'] > 0) {
            $this->watermark_size = $theme_options['watermark_size'];
        }

        if (isset($theme_options['watermark_opacity']) && is_numeric($theme_options['watermark_opacity']) && $theme_options['watermark_opacity'] > 0) {
            $this->watermark_opacity = $theme_options['watermark_opacity'];
        }

        $position_list = [
            'top-left',
            'top-right',
            'center',
            'bottom-left',
            'bottom-right',
        ];

        if (isset($theme_options['watermark_position']) && in_array($theme_options['watermark_position'], $position_list)) {
            $this->watermark_position = $theme_options['watermark_position'];
        }
    }

    public function store($file)
    {
        if ($file) {
            $watermark = $this->getWatermarkLink();
            $save_path = storage_path('app/public/image_uploads');
            $image_name = Str::random(15) . '.jpg';
            // Check if folder if not exsist
            if (!file_exists($save_path)) {
                mkdir($save_path, 777, true);
            }
            if (!file_exists($save_path . '/thumbs')) {
                mkdir($save_path . '/thumbs', 777, true);
            }
            // Create image and thumb
            $image = Image::make($file);
            $thumb = Image::make($file)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            // create water mark
            $width = $image->width();
            $water_mark_width = $this->watermark_size / 100 * $width;
            $watermark = $this->createWatermark($water_mark_width);
            $watermark_thumb = $this->createWatermark(80);
            if (isset($watermark)) {
                $image->insert($watermark, $this->watermark_position);
            }
            if (isset($watermark_thumb)) {
                $thumb->insert($watermark_thumb, $this->watermark_position);
            }
            //save image
            $image->save(storage_path('app/public/image_uploads/' . $image_name));
            $thumb->save(storage_path('app/public/image_uploads/thumbs/' . $image_name));

            return [
                'path' => Storage::url('image_uploads/' . $image_name),
                'storage_path' => 'image_uploads/' . $image_name,
                'thumb' => $this->getThumb('image_uploads/' . $image_name),
            ];
        }
    }

    public function destroy(Request $request)
    {
        Storage::delete('public/' . $request->storage_path);
        Storage::delete('public/' . $this->getThumb($request->storage_path));
    }

    private function getWatermarkLink()
    {
        $image = ThemeOption::get('watermark_logo');
        if ($image) {
            $link = explode(',', $image)[0] ?? null;
            if (!$link) {
                return null;
            }
            $watermark = Str::replaceFirst('/storage', '', $link);

            return storage_path('app/public' . $watermark);
        }
        return null;
    }

    private function createWatermark($width)
    {
        $link = $this->getWatermarkLink();
        try {
            $watermark = Image::make($link)
                ->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->opacity($this->watermark_opacity);
            return $watermark;
        } catch (\Exception $e) {
            return null;
        }
        return null;
    }

    private function getThumb($string)
    {
        return Str::replaceLast('/', '/thumbs/', $string);
    }

}