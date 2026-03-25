<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Application;

use App\Modules\Tickets\Domain\Events\TicketCreated;
use App\Modules\Tickets\Domain\Ports\TicketRepositoryPort;
use App\Modules\Tickets\Domain\Ticket;
use App\Modules\Tickets\Domain\TicketStatus;
use App\Modules\Tickets\Domain\TicketType;
use App\Shared\Domain\MessageBus\MessageBusPort;

class CreateTicketUseCase
{
    public function __construct(
        private readonly TicketRepositoryPort $ticketRepository,
        private readonly MessageBusPort $messageBus,
    ) {
    }

    public function execute(int $customerId, TicketType $type, string $subject, string $content): void
    {
        $ticket = new Ticket(
            id: null,
            salesforceId: null,
            customerId: $customerId,
            type: $type,
            subject: $subject,
            content: $content,
            status: TicketStatus::waiting_for_agent,
            lastSalesforceSync: null,
        );

        $saved = $this->ticketRepository->addTicket($ticket);
        $this->messageBus->dispatch(new TicketCreated($saved->id));
    }
}
