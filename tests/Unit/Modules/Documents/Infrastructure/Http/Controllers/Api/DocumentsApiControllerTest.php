<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Documents\Infrastructure\Http\Controllers\Api;

use App\Modules\Auth\Domain\Ports\AuthPort;
use App\Modules\Documents\Application\ListDocumentsUseCase;
use App\Modules\Documents\Infrastructure\Http\Controllers\Api\DocumentsApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class DocumentsApiControllerTest extends TestCase
{
    private AuthPort $authPort;
    private ListDocumentsUseCase $listDocumentsUseCase;
    private DocumentsApiController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authPort = $this->createMock(AuthPort::class);
        $this->listDocumentsUseCase = $this->createMock(ListDocumentsUseCase::class);
        $this->controller = new DocumentsApiController($this->listDocumentsUseCase, $this->authPort);
    }

    public function test_list_checks_auth_for_customer(): void
    {
        $customerId = 42;

        $this->authPort->expects($this->once())
            ->method('isLoggedIn')
            ->with($customerId);

        $this->listDocumentsUseCase->method('execute')->willReturn([]);

        $this->controller->list(new Request(), $customerId);
    }

    public function test_list_returns_json_response(): void
    {
        $this->authPort->method('isLoggedIn');
        $this->listDocumentsUseCase->method('execute')->willReturn([]);

        $response = $this->controller->list(new Request(), 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function test_list_returns_documents_from_use_case(): void
    {
        $customerId = 7;
        $documents = [
            ['id' => 1, 'name' => 'Invoice.pdf'],
            ['id' => 2, 'name' => 'Contract.pdf'],
        ];

        $this->authPort->method('isLoggedIn');
        $this->listDocumentsUseCase->expects($this->once())
            ->method('execute')
            ->with($customerId)
            ->willReturn($documents);

        $response = $this->controller->list(new Request(), $customerId);

        $this->assertSame($documents, $response->getData(true));
    }

    public function test_list_propagates_auth_exception(): void
    {
        $this->authPort->method('isLoggedIn')
            ->willThrowException(new \Exception('Forbidden', 403));

        $this->listDocumentsUseCase->expects($this->never())->method('execute');

        $this->expectException(\Exception::class);
        $this->expectExceptionCode(403);

        $this->controller->list(new Request(), 99);
    }
}
