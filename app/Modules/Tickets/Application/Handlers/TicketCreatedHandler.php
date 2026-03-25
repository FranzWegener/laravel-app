<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Application\Handlers;

use App\Modules\Tickets\Domain\Events\TicketCreated;
use App\Modules\Tickets\Domain\Ports\TicketRepositoryPort;
use App\Modules\Tickets\Domain\Ports\TicketSyncServicePort;
use App\Shared\Domain\Exceptions\InvalidArgumentException;
use App\Shared\Domain\MessageBus\MessageHandlerInterface;
use App\Shared\Domain\MessageBus\MessageInterface;

readonly class TicketCreatedHandler implements MessageHandlerInterface
{
    public function __construct(
        private TicketSyncServicePort $ticketSyncService,
        private TicketRepositoryPort $ticketRepository,
    ) {
    }

    public function handle(MessageInterface $message): void
    {
        if (!$message instanceof TicketCreated) {
            throw new InvalidArgumentException('Invalid message type');
        }

        $ticket = $this->ticketRepository->getById($message->ticketId);
        if (!$ticket) {
            throw new InvalidArgumentException('Cannot find ticket with id ' . $message->ticketId);
        }

        // Not catching the exception so it will be caught and logged centrally AND so the MessageBus can retry
        $this->ticketSyncService->uploadTicket($ticket);
        $this->ticketRepository->markTicketAsSynced($message->ticketId, new \DateTime());
    }
}
