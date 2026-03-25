<?php

namespace App\Providers;

use App\Modules\Auth\Infrastructure\Providers\AuthServiceProvider;
use App\Modules\Documents\Infrastructure\Providers\DocumentsServiceProvider;
use App\Modules\Tickets\Infrastructure\Providers\TicketsServiceProvider;
use App\Shared\Infrastructure\Providers\SharedServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(SharedServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(TicketsServiceProvider::class);
        $this->app->register(DocumentsServiceProvider::class);
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
