<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Documents\Infrastructure\Salesforce;

use App\Modules\Documents\Infrastructure\Salesforce\SalesforceDocumentsAdapter;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Tests\TestCase;

class SalesforceDocumentsAdapterTest extends TestCase
{
    private const FOLDER = 'mocks/salesforce/documents/';

    private SalesforceDocumentsAdapter $adapter;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        $this->adapter = new SalesforceDocumentsAdapter();
    }

    public function test_get_documents_list_returns_decoded_json(): void
    {
        $customerId = 5;
        $documents = [
            ['id' => 1, 'name' => 'Invoice.pdf'],
            ['id' => 2, 'name' => 'Contract.pdf'],
        ];

        Storage::disk('local')->put(
            self::FOLDER . "documents-{$customerId}.json",
            json_encode($documents)
        );

        $result = $this->adapter->getDocumentsList($customerId);

        $this->assertSame($documents, $result);
    }

    public function test_get_documents_list_returns_empty_array_when_file_missing(): void
    {
        $result = $this->adapter->getDocumentsList(99);

        $this->assertSame([], $result);
    }

    public function test_get_documents_list_returns_empty_array_for_invalid_json(): void
    {
        Storage::disk('local')->put(self::FOLDER . 'documents-1.json', 'not-valid-json');

        $result = $this->adapter->getDocumentsList(1);

        $this->assertSame([], $result);
    }

    public function test_get_document_returns_streamed_response_when_document_found(): void
    {
        $customerId = 3;
        $documentId = 2;
        $documents = [
            ['id' => 1, 'name' => 'Invoice.pdf'],
            ['id' => 2, 'name' => 'Contract.pdf'],
        ];

        Storage::disk('local')->put(
            self::FOLDER . "documents-{$customerId}.json",
            json_encode($documents)
        );
        Storage::disk('local')->put(
            self::FOLDER . "files/{$customerId}/Contract.pdf",
            '%PDF-1.4 fake content'
        );

        $result = $this->adapter->getDocument($customerId, $documentId);

        $this->assertInstanceOf(StreamedResponse::class, $result);
    }

    public function test_get_document_returns_null_when_document_id_not_in_list(): void
    {
        $customerId = 3;
        $documents = [['id' => 1, 'name' => 'Invoice.pdf']];

        Storage::disk('local')->put(
            self::FOLDER . "documents-{$customerId}.json",
            json_encode($documents)
        );

        $result = $this->adapter->getDocument($customerId, 999);

        $this->assertNull($result);
    }

    public function test_get_document_returns_null_when_documents_list_is_empty(): void
    {
        Storage::disk('local')->put(self::FOLDER . 'documents-1.json', json_encode([]));

        $result = $this->adapter->getDocument(1, 1);

        $this->assertNull($result);
    }

    public function test_get_document_uses_customer_id_in_file_path(): void
    {
        $customerId = 7;
        $documentId = 10;
        $documents = [['id' => 10, 'name' => 'Report.pdf']];

        Storage::disk('local')->put(
            self::FOLDER . "documents-{$customerId}.json",
            json_encode($documents)
        );
        Storage::disk('local')->put(
            self::FOLDER . "files/{$customerId}/Report.pdf",
            'fake pdf'
        );

        $result = $this->adapter->getDocument($customerId, $documentId);

        $this->assertInstanceOf(StreamedResponse::class, $result);
        Storage::disk('local')->assertExists(self::FOLDER . "files/{$customerId}/Report.pdf");
    }
}
