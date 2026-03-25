<?php

declare(strict_types=1);

namespace App\Modules\Documents\Infrastructure\Http\Controllers\Api;

use App\Modules\Auth\Domain\Ports\AuthPort;
use App\Modules\Documents\Application\ListDocumentsUseCase;
use App\Shared\Infrastructure\Http\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentsApiController extends BaseController
{
    public function __construct(
        private readonly ListDocumentsUseCase $listDocumentsUseCase,
        private readonly AuthPort $authPort,
    ) {
    }

    public function list(Request $request, int $customerId): JsonResponse
    {
        $this->authPort->isLoggedIn($customerId);
        $documents = $this->listDocumentsUseCase->execute($customerId);

        return new JsonResponse($documents);
    }
}
