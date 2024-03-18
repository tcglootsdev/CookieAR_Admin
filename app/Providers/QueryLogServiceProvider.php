<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class QueryLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        DB::listen(function(QueryExecuted $query) {
            Log::channel('query')->info($query->sql . ' [' . implode(', ', $query->bindings) . ']');
        });
    }
}
