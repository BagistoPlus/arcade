<?php

use EldoMagan\BagistoArcade\ArcadeManager;
use EldoMagan\BagistoArcade\ThemeEditor;
use Illuminate\Support\Facades\Storage;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Repositories\ProductFlatRepository;

if (! function_exists('arcade')) {
    function arcade()
    {
        return app(ArcadeManager::class);
    }
}

if (! function_exists('arcadeEditor')) {
    function arcadeEditor()
    {
        return app(ThemeEditor::class);
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

if (! function_exists('arcade_get_product')) {
    function arcade_get_product($productId)
    {
        return app(ProductFlatRepository::class)->find($productId);
    }
}


if (! function_exists('arcade_clear_inline_styles')) {
    function arcade_clear_inline_styles($html)
    {
        return preg_replace('#(<[a-z0-6 ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $html);
    }
}
