<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Infrastructure\Providers;

use App\Modules\Tickets\Application\Handlers\TicketCreatedHandler;
use App\Modules\Tickets\Domain\Events\TicketCreated;
use App\Modules\Tickets\Domain\Ports\TicketRepositoryPort;
use App\Modules\Tickets\Domain\Ports\TicketSyncServicePort;
use App\Modules\Tickets\Infrastructure\Persistence\TicketRepository;
use App\Modules\Tickets\Infrastructure\Salesforce\SalesforceTicketAdapter;
use App\Shared\Domain\MessageBus\MessageBusPort;
use Illuminate\Support\ServiceProvider;

class TicketsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TicketRepositoryPort::class, TicketRepository::class);
        $this->app->bind(TicketSyncServicePort::class, SalesforceTicketAdapter::class);
    }

    public function boot(): void
    {
        $bus = $this->app->make(MessageBusPort::class);
        $bus->registerHandler(TicketCreated::class, $this->app->make(TicketCreatedHandler::class));
    }
}
