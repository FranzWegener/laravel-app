<?php

declare(strict_types=1);

namespace App\Modules\Documents\Application;

use App\Modules\Documents\Domain\Ports\DocumentStoragePort;

class ListDocumentsUseCase
{
    public function __construct(
        private readonly DocumentStoragePort $documentStorage,
    ) {
    }

    public function execute(int $customerId): array
    {
        return $this->documentStorage->getDocumentsList($customerId);
    }
}
