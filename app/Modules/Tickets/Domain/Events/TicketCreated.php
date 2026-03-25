<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Domain\Events;

use App\Shared\Domain\MessageBus\MessageInterface;

final readonly class TicketCreated implements MessageInterface
{
    public function __construct(public int $ticketId)
    {
    }
}
