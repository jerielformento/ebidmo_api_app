<?php

namespace App\Http\Helper;

use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Helper
{
    public static function createSlug($model, $title)
    {
        $slug = Str::slug($title);

        if (DB::table($model)->where('slug', $slug)->exists()) {
            $count = DB::table($model)->where('name', $title)->count();

            if($count > 0) {
                return "{$slug}-$count";
            }
        }

        return $slug;
    }
}
