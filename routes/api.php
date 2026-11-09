
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BukuApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    // Menampilkan daftar buku
    Route::get('/bukus', [BukuApiController::class, 'index']);

    // Menampilkan detail buku
    Route::get('/bukus/{id}', [BukuApiController::class, 'show']);

    // Route yang membutuhkan autentikasi
    Route::middleware('auth:sanctum')->group(function () {

        // Menambahkan buku
        Route::post('/bukus', [BukuApiController::class, 'store']);

        // Mengganti seluruh data buku
        Route::put('/bukus/{id}', [BukuApiController::class, 'update']);

        // Memperbarui sebagian data buku
        Route::patch('/bukus/{id}', [BukuApiController::class, 'partialUpdate']);

        // Menghapus buku
        Route::delete('/bukus/{id}', [BukuApiController::class, 'destroy']);
    });
});
