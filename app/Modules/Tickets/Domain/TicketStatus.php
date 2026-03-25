<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Domain;

use App\Shared\Infrastructure\Helpers\EnumFromName;

enum TicketStatus: string
{
    use EnumFromName;

    case waiting_for_agent = 'waiting_for_agent';
    case in_progress = 'in_progress';
    case waiting_for_customer = 'waiting_for_customer';
    case waiting_for_other = 'waiting_for_other';
    case done = 'done';
}
