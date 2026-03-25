<?php

declare(strict_types=1);

namespace App\Modules\Auth\Infrastructure\Providers;

use App\Modules\Auth\Domain\Ports\AuthPort;
use App\Modules\Auth\Domain\Ports\UserRepositoryPort;
use App\Modules\Auth\Infrastructure\Laravel\LaravelAuthAdapter;
use App\Modules\Auth\Infrastructure\Persistence\UserRepository;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthPort::class, LaravelAuthAdapter::class);
        $this->app->bind(UserRepositoryPort::class, UserRepository::class);
    }
}
