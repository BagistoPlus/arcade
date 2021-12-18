<?php

use EldoMagan\BagistoArcade\ArcadeManager;
use Illuminate\Support\Facades\Storage;
use Webkul\Category\Repositories\CategoryRepository;

if (! function_exists('arcade')) {
    function arcade()
    {
        return app(ArcadeManager::class);
    }
}

if (! function_exists('arcade_image')) {
    function arcade_image($image)
    {
        return Storage::disk(config('arcade.images_storage'))->url($image);
    }
}

if (! function_exists('arcade_get_category')) {
    function arcade_get_category($categoryId)
    {
        return app(CategoryRepository::class)->find($categoryId);
    }
}
