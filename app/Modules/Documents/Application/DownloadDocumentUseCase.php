<?php

declare(strict_types=1);

namespace App\Modules\Documents\Application;

use App\Modules\Documents\Domain\Ports\DocumentStoragePort;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadDocumentUseCase
{
    public function __construct(
        private readonly DocumentStoragePort $documentStorage,
    ) {
    }

    public function execute(int $customerId, int $documentId): ?StreamedResponse
    {
        return $this->documentStorage->getDocument($customerId, $documentId);
    }
}
