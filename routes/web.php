<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;

Route::get('/', [AsetController::class, 'index']);
Route::get('/tambah_aset', [AsetController::class, 'tambah']);
Route::post('/simpan_aset', [AsetController::class, 'simpan_aset']);
Route::get('/hapus_aset/{id}', [AsetController::class, 'hapus_aset']);
Route::get('/edit_aset/{id}', [AsetController::class, 'edit_aset']);
Route::post('/update_aset/{id}', [AsetController::class, 'update_aset']);








