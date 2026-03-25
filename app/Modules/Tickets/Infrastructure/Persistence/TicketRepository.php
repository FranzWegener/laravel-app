<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Infrastructure\Persistence;

use App\Modules\Tickets\Domain\Ports\TicketRepositoryPort;
use App\Modules\Tickets\Domain\Ticket;
use App\Modules\Tickets\Domain\TicketStatus;
use App\Modules\Tickets\Domain\TicketType;

class TicketRepository implements TicketRepositoryPort
{
    public function addTicket(Ticket $ticket): Ticket
    {
        $model = EloquentTicket::create([
            'customer_id' => $ticket->customerId,
            'type'        => $ticket->type->name,
            'subject'     => $ticket->subject,
            'content'     => $ticket->content,
            'status'      => $ticket->status,
        ]);

        return $this->toDomain($model);
    }

    public function getById(int $id): ?Ticket
    {
        $model = EloquentTicket::find($id);

        return $model ? $this->toDomain($model) : null;
    }

    public function markTicketAsSynced(int $id, \DateTime $timeOfSync): Ticket
    {
        $model = EloquentTicket::find($id);
        $model->last_salesforce_sync = $timeOfSync->format('Y-m-d H:i:s');
        $model->save();

        return $this->toDomain($model);
    }

    private function toDomain(EloquentTicket $model): Ticket
    {
        return new Ticket(
            id: $model->id,
            salesforceId: $model->salesforce_id,
            customerId: $model->customer_id,
            type: TicketType::fromName($model->type instanceof TicketType ? $model->type->name : (string) $model->type),
            subject: $model->subject,
            content: $model->content,
            status: TicketStatus::from(
                $model->status instanceof TicketStatus ? $model->status->value : (string) $model->status
            ),
            lastSalesforceSync: $model->last_salesforce_sync,
        );
    }
}
