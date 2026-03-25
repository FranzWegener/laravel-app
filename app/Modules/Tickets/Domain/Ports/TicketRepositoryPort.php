<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Domain\Ports;

use App\Modules\Tickets\Domain\Ticket;

interface TicketRepositoryPort
{
    public function addTicket(Ticket $ticket): Ticket;

    public function getById(int $id): ?Ticket;

    public function markTicketAsSynced(int $id, \DateTime $timeOfSync): Ticket;
}
