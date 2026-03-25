<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Domain\Ports;

use App\Modules\Tickets\Domain\Ticket;
use App\Shared\Domain\Exceptions\SalesforceException;

interface TicketSyncServicePort
{
    public function getTicketList(int $customerId): array;

    /**
     * @throws SalesforceException
     */
    public function uploadTicket(Ticket $ticket): void;
}
