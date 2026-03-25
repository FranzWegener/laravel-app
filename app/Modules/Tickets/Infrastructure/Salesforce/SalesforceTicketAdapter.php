<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Infrastructure\Salesforce;

use App\Modules\Tickets\Domain\Ports\TicketSyncServicePort;
use App\Modules\Tickets\Domain\Ticket;
use App\Shared\Domain\Exceptions\SalesforceException;
use Illuminate\Support\Facades\Storage;

class SalesforceTicketAdapter implements TicketSyncServicePort
{
    private const SALESFORCE_TICKET_FOLDER = 'mocks/salesforce/tickets/';

    public function getTicketList(int $customerId): array
    {
        $data = Storage::disk('local')->get(self::SALESFORCE_TICKET_FOLDER . 'tickets-' . $customerId . '.json');
        return json_decode($data, true);
    }

    /**
     * @throws SalesforceException
     */
    public function uploadTicket(Ticket $ticket): void
    {
        if (rand(1, 100) < 2) { // Simulate network issues
            throw new SalesforceException('Salesforce ticket upload failed');
        }
    }
}
