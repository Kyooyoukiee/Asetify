<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;

Route::get('/', [AsetController::class, 'tampil']);

Route::post('/simpan_aset', [AsetController::class, 'simpan']);







