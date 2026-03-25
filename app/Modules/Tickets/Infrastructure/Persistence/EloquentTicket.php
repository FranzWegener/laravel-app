<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Infrastructure\Persistence;

use App\Modules\Tickets\Domain\TicketStatus;
use App\Modules\Tickets\Domain\TicketType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null $id
 * @property string|null $salesforce_id
 * @property int $customer_id
 * @property TicketType $type
 * @property string $subject
 * @property string $content
 * @property TicketStatus $status
 * @property \DateTimeInterface|null $last_salesforce_sync
 */
#[Fillable(['salesforce_id', 'customer_id', 'type', 'subject', 'content', 'status', 'last_salesforce_sync'])]
class EloquentTicket extends Model
{
    protected $table = 'tickets';

    protected function casts(): array
    {
        return [
            'last_salesforce_sync' => 'datetime',
        ];
    }
}
