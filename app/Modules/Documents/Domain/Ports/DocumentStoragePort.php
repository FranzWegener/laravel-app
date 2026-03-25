<?php

declare(strict_types=1);

namespace App\Modules\Documents\Domain\Ports;

use Symfony\Component\HttpFoundation\StreamedResponse;

interface DocumentStoragePort
{
    public function getDocumentsList(int $customerId): array;

    public function getDocument(int $customerId, int $documentId): ?StreamedResponse;
}
