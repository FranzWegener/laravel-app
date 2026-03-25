<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Domain;

use App\Shared\Infrastructure\Helpers\EnumFromName;

enum TicketType: string
{
    use EnumFromName;

    case question = 'Anfrage';
    case problem = 'Problem';
    case other = 'Sonstiges';
}
