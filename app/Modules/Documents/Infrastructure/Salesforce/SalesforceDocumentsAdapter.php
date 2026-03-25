<?php

declare(strict_types=1);

namespace App\Modules\Documents\Infrastructure\Salesforce;

use App\Modules\Documents\Domain\Ports\DocumentStoragePort;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SalesforceDocumentsAdapter implements DocumentStoragePort
{
    private const SALESFORCE_DOCUMENTS_FOLDER = 'mocks/salesforce/documents/';

    public function getDocumentsList(int $customerId): array
    {
        $data = Storage::disk('local')->get(self::SALESFORCE_DOCUMENTS_FOLDER . 'documents-' . $customerId . '.json');
        return (array)json_decode($data ?: '[]', true);
    }

    public function getDocument(int $customerId, int $documentId): ?StreamedResponse
    {
        $documentsData = $this->getDocumentsList($customerId);
        foreach ($documentsData as $document) {
            if ($document['id'] == $documentId) {
                return Storage::disk('local')->download(
                    self::SALESFORCE_DOCUMENTS_FOLDER . 'files/' . $customerId . '/' . $document['name']
                );
            }
        }
        return null;
    }
}
