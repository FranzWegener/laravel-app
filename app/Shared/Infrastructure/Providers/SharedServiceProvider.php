<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Providers;

use App\Shared\Domain\MessageBus\MessageBusPort;
use App\Shared\Infrastructure\MessageBus\InMemoryMessageBus;
use Illuminate\Support\ServiceProvider;

class SharedServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MessageBusPort::class, InMemoryMessageBus::class);
    }
}
