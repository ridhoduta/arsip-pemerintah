<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SuratController;
Route::get('surat/download/{id}', [SuratController::class, 'download']);
Route::post('/surat/{id}/update-file', [SuratController::class, 'updateFile']);
// Route::get('surat/coba', [SuratController::class, 'coba']);
Route::apiResource('kategori', KategoriController::class);
Route::apiResource('surat', SuratController::class);

