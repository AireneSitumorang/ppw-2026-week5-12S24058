Route::prefix('v1')->group(function () {
    Route::get('/bukus', [BukuApiController::class, 'index']);
    Route::get('/bukus/{id}', [BukuApiController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/bukus', [BukuApiController::class, 'store']);

        Route::put('/bukus/{id}', [BukuApiController::class, 'update']);

        Route::patch('/bukus/{id}', [BukuApiController::class, 'partialUpdate']);

        Route::delete('/bukus/{id}', [BukuApiController::class, 'destroy']);
    });
});