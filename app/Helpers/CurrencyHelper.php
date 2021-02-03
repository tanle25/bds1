<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static function beautyPrice($price)
    {
        if ($price >= 1000000000) {
            return round($price / 1000000000, 1) . ' tỉ';
        } elseif ($price >= 1000000) {
            return round($price / 1000000, 0) . ' triệu';
        } elseif ($price >= 1000) {
            return round($price / 1000, 0) . ' nghìn';
        }{
            return $price;
        }
    }
}