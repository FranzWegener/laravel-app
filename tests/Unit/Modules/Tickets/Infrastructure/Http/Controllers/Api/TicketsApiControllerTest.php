<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Tickets\Infrastructure\Http\Controllers\Api;

use App\Modules\Auth\Domain\Ports\AuthPort;
use App\Modules\Tickets\Application\CreateTicketUseCase;
use App\Modules\Tickets\Application\ListTicketsUseCase;
use App\Modules\Tickets\Domain\TicketType;
use App\Modules\Tickets\Infrastructure\Http\Controllers\Api\TicketsApiController;
use App\Modules\Tickets\Infrastructure\Http\Requests\NewTicketRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class TicketsApiControllerTest extends TestCase
{
    private AuthPort $authPort;
    private ListTicketsUseCase $listTicketsUseCase;
    private CreateTicketUseCase $createTicketUseCase;
    private TicketsApiController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authPort = $this->createMock(AuthPort::class);
        $this->listTicketsUseCase = $this->createMock(ListTicketsUseCase::class);
        $this->createTicketUseCase = $this->createMock(CreateTicketUseCase::class);
        $this->controller = new TicketsApiController(
            $this->listTicketsUseCase,
            $this->createTicketUseCase,
            $this->authPort,
        );
    }

    public function test_list_checks_auth_for_customer(): void
    {
        $customerId = 42;

        $this->authPort->expects($this->once())
            ->method('isLoggedIn')
            ->with($customerId);

        $this->listTicketsUseCase->method('execute')->willReturn([]);

        $this->controller->list(new Request(), $customerId);
    }

    public function test_list_returns_json_response(): void
    {
        $this->authPort->method('isLoggedIn');
        $this->listTicketsUseCase->method('execute')->willReturn([]);

        $response = $this->controller->list(new Request(), 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function test_list_returns_tickets_from_use_case(): void
    {
        $customerId = 7;
        $tickets = [
            ['id' => 1, 'subject' => 'Cannot login', 'type' => 'problem'],
            ['id' => 2, 'subject' => 'How to reset?', 'type' => 'question'],
        ];

        $this->authPort->method('isLoggedIn');
        $this->listTicketsUseCase->expects($this->once())
            ->method('execute')
            ->with($customerId)
            ->willReturn($tickets);

        $response = $this->controller->list(new Request(), $customerId);

        $this->assertSame($tickets, $response->getData(true));
    }

    public function test_list_propagates_auth_exception(): void
    {
        $this->authPort->method('isLoggedIn')
            ->willThrowException(new \Exception('Forbidden', 403));

        $this->listTicketsUseCase->expects($this->never())->method('execute');

        $this->expectException(\Exception::class);
        $this->expectExceptionCode(403);

        $this->controller->list(new Request(), 99);
    }

    public function test_create_checks_auth_for_customer(): void
    {
        $customerId = 42;

        $this->authPort->expects($this->once())
            ->method('isLoggedIn')
            ->with($customerId);

        $request = $this->makeNewTicketRequest('problem', 'Some subject', 'Some content');

        $this->controller->create($request, $customerId);
    }

    public function test_create_returns_201_json_response(): void
    {
        $this->authPort->method('isLoggedIn');

        $request = $this->makeNewTicketRequest('question', 'How do I log in?', 'I forgot my password.');

        $response = $this->controller->create($request, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(201, $response->getStatusCode());
        $this->assertTrue(new \stdClass() == $response->getData());
    }

    public function test_create_calls_use_case_with_correct_arguments(): void
    {
        $customerId = 5;
        $subject = 'Login broken';
        $content = 'I cannot log in at all.';

        $this->authPort->method('isLoggedIn');
        $this->createTicketUseCase->expects($this->once())
            ->method('execute')
            ->with($customerId, TicketType::problem, $subject, $content);

        $request = $this->makeNewTicketRequest('problem', $subject, $content);

        $this->controller->create($request, $customerId);
    }

    public function test_create_maps_question_type_correctly(): void
    {
        $this->authPort->method('isLoggedIn');
        $this->createTicketUseCase->expects($this->once())
            ->method('execute')
            ->with($this->anything(), TicketType::question, $this->anything(), $this->anything());

        $this->controller->create($this->makeNewTicketRequest('question', 'A subject', 'Some content'), 1);
    }

    public function test_create_maps_other_type_correctly(): void
    {
        $this->authPort->method('isLoggedIn');
        $this->createTicketUseCase->expects($this->once())
            ->method('execute')
            ->with($this->anything(), TicketType::other, $this->anything(), $this->anything());

        $this->controller->create($this->makeNewTicketRequest('other', 'A subject', 'Some content'), 1);
    }

    public function test_create_propagates_auth_exception(): void
    {
        $this->authPort->method('isLoggedIn')
            ->willThrowException(new \Exception('Forbidden', 403));

        $this->createTicketUseCase->expects($this->never())->method('execute');

        $this->expectException(\Exception::class);
        $this->expectExceptionCode(403);

        $this->controller->create($this->makeNewTicketRequest('problem', 'Subject', 'Content'), 99);
    }

    private function makeNewTicketRequest(string $type, string $subject, string $content): NewTicketRequest
    {
        $request = new NewTicketRequest();
        $request->merge(['type' => $type, 'subject' => $subject, 'content' => $content]);

        return $request;
    }
}
