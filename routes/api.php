
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BukuApiController;

// Route bawaan Laravel (tetap dipertahankan)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// REST API SIPUS-Del versi 1
Route::get('/v1/buku', [BukuApiController::class, 'index']);
