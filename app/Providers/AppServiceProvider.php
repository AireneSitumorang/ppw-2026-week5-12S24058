<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Sembunyikan warning deprecated PHP 8.5
        error_reporting(E_ALL & ~E_DEPRECATED);

        // Aktifkan styling Bootstrap 5 untuk pagination
        Paginator::useBootstrapFive();

        // Audit Kueri SQL pembuktian Eager Loading mitigasi N+1 problem
        DB::listen(function ($query) {
            Log::info(sprintf(
                "[SQL AUDIT] (%.2f ms) %s [Bindings: %s]",
                $query->time,
                $query->sql,
                json_encode($query->bindings)
            ));
        });
    }
}