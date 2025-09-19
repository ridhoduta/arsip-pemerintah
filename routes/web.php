<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;

Route::get('/', function () {
    return redirect('/app/surats');
});

// Catch-all route untuk React
Route::get('/app/{any}', function () {
    return file_get_contents(public_path('react/index.html'));
})->where('any', '.*');
