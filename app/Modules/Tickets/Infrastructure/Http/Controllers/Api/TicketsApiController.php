<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Infrastructure\Http\Controllers\Api;

use App\Modules\Auth\Domain\Ports\AuthPort;
use App\Modules\Tickets\Application\CreateTicketUseCase;
use App\Modules\Tickets\Application\ListTicketsUseCase;
use App\Modules\Tickets\Domain\TicketType;
use App\Modules\Tickets\Infrastructure\Http\Requests\NewTicketRequest;
use App\Shared\Infrastructure\Http\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketsApiController extends BaseController
{
    public function __construct(
        private readonly ListTicketsUseCase $listTicketsUseCase,
        private readonly CreateTicketUseCase $createTicketUseCase,
        private readonly AuthPort $authPort,
    ) {
    }

    public function list(Request $request, int $customerId): JsonResponse
    {
        $this->authPort->isLoggedIn($customerId);
        $tickets = $this->listTicketsUseCase->execute($customerId);

        return new JsonResponse($tickets);
    }

    public function create(NewTicketRequest $request, int $customerId): JsonResponse
    {
        $this->authPort->isLoggedIn($customerId);
        $this->createTicketUseCase->execute(
            $customerId,
            TicketType::fromName($request->input('type')),
            $request->input('subject'),
            $request->input('content'),
        );

        return new JsonResponse(null, 201);
    }
}
