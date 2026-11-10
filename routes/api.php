
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BukuApiController;
use App\Http\Controllers\Api\V1\PeminjamanApiController;

// AUTHENTICATION
Route::prefix('v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// USER
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// SIPUS API V1
Route::prefix('v1')->group(function () {

    // BUKU PUBLIK
    Route::get('/bukus', [BukuApiController::class, 'index']);
    Route::get('/bukus/{id}', [BukuApiController::class, 'show']);

    // ROUTE YANG MEMBUTUHKAN TOKEN
    Route::middleware('auth:sanctum')->group(function () {

        // CRUD BUKU
        Route::post('/bukus', [BukuApiController::class, 'store']);
        Route::put('/bukus/{id}', [BukuApiController::class, 'update']);
        Route::patch('/bukus/{id}', [BukuApiController::class, 'partialUpdate']);
        Route::delete('/bukus/{id}', [BukuApiController::class, 'destroy']);

        // PEMINJAMAN
        Route::get('/peminjamans', [PeminjamanApiController::class, 'index']);
        Route::get('/peminjamans/{id}', [PeminjamanApiController::class, 'show']);
        Route::post('/peminjamans', [PeminjamanApiController::class, 'store']);
        Route::patch('/peminjamans/{id}/kembalikan', [PeminjamanApiController::class, 'kembalikan']);
    });
});
