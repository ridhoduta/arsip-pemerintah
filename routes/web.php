<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;

Route::get('/app/{any?}', function () {
    return file_get_contents(public_path('react/index.html'));
})->where('any', '.*');
