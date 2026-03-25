<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Application;

use App\Modules\Tickets\Domain\Ports\TicketSyncServicePort;

class ListTicketsUseCase
{
    public function __construct(
        private readonly TicketSyncServicePort $ticketSyncService,
    ) {
    }

    public function execute(int $customerId): array
    {
        return $this->ticketSyncService->getTicketList($customerId);
    }
}
