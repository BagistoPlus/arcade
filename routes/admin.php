<?php

use Illuminate\Support\Facades\Route;
use EldoMagan\BagistoArcade\Http\Controllers\Admin\ThemeController;

Route::group(['middleware' => ['web', 'admin_locale', 'admin']], function () {

    Route::prefix(config('app.admin_url') . '/arcade')->group(function () {

        Route::get('themes', [ThemeController::class, 'index'])
            ->name('arcade.admin.themes.index');

        Route::post('/themes/editor/{theme}/persist', [ThemeController::class, 'persistTheme']);

        Route::get('/themes/editor/{theme}/{path?}', [ThemeController::class, 'editor'])
            ->where('path', '.*')
            ->name('arcade.admin.themes.editor');
    });

});
