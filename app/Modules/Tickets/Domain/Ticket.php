<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Domain;

class Ticket
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $salesforceId,
        public readonly int $customerId,
        public readonly TicketType $type,
        public readonly string $subject,
        public readonly string $content,
        public readonly TicketStatus $status,
        public readonly ?\DateTimeInterface $lastSalesforceSync,
    ) {
    }
}
