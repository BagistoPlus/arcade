<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {

});
