<?php

declare(strict_types=1);

// Shadow Laravel global helpers in the controller's namespace so the container is not required.
namespace App\Modules\Auth\Infrastructure\Http\Controllers {
    if (!function_exists('App\Modules\Auth\Infrastructure\Http\Controllers\redirect')) {
        function redirect(?string $to = null): object
        {
            return new class ($to) {
                public function __construct(private readonly ?string $url) {}

                public function with(string $key, mixed $value): static
                {
                    return $this;
                }

                public function getTargetUrl(): ?string
                {
                    return $this->url;
                }
            };
        }
    }

    if (!function_exists('App\Modules\Auth\Infrastructure\Http\Controllers\view')) {
        function view(string $view, array $data = []): object
        {
            return new class ($view) {
                public function __construct(private readonly string $name) {}

                public function getName(): string
                {
                    return $this->name;
                }
            };
        }
    }
}

namespace Tests\Unit\Modules\Auth\Infrastructure\Http\Controllers {
    use App\Modules\Auth\Application\CreateUserUseCase;
    use App\Modules\Auth\Infrastructure\Http\Controllers\UserController;
    use Illuminate\Http\Request;
    use PHPUnit\Framework\TestCase;

    class UserControllerTest extends TestCase
    {
        private CreateUserUseCase $createUserUseCase;
        private UserController $controller;

        protected function setUp(): void
        {
            parent::setUp();

            $this->createUserUseCase = $this->createMock(CreateUserUseCase::class);
            $this->controller = new UserController($this->createUserUseCase);
        }

        public function test_createForm_returns_user_create_form_view(): void
        {
            $result = $this->controller->createForm();

            $this->assertSame('user-create-form', $result->getName());
        }

        public function test_create_calls_use_case_with_name_email_and_password(): void
        {
            $request = $this->mockValidRequest(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'secret123']);

            $this->createUserUseCase->expects($this->once())
                ->method('execute')
                ->with('John Doe', 'john@example.com', 'secret123');

            $this->controller->create($request);
        }

        public function test_create_redirects_to_users_create_on_success(): void
        {
            $request = $this->mockValidRequest(['name' => 'Jane', 'email' => 'jane@example.com', 'password' => 'password123']);

            $response = $this->controller->create($request);

            $this->assertSame('/users/create', $response->getTargetUrl());
        }

        public function test_create_does_not_call_use_case_when_validation_fails(): void
        {
            $request = $this->mockValidRequest([]);
            $request->exceptionToThrow = new \RuntimeException('Validation failed');

            $this->createUserUseCase->expects($this->never())->method('execute');

            $this->expectException(\RuntimeException::class);

            $this->controller->create($request);
        }

        public function test_create_validates_required_fields(): void
        {
            $request = $this->mockValidRequest(['name' => 'Test', 'email' => 'test@example.com', 'password' => 'password123']);
            $request->merge(['name' => 'Test', 'email' => 'test@example.com', 'password' => 'password123']);

            $this->controller->create($request);

            $this->assertArrayHasKey('name', $request->calls[0]);
            $this->assertArrayHasKey('email', $request->calls[0]);
            $this->assertArrayHasKey('password', $request->calls[0]);
            $this->assertStringContainsString('required', $request->calls[0]['name']);
            $this->assertStringContainsString('required', $request->calls[0]['email']);
            $this->assertStringContainsString('required', $request->calls[0]['password']);
        }

        private function mockValidRequest(array $input): Request
        {
            $request = new class ($input) extends Request
            {
                public ?\Throwable $exceptionToThrow = null;
                public ?array $result = null;
                public array $calls = [];

                public function validate(array $rules, ...$params): array
                {
                    $this->calls[] = $rules;
                    if ($this->exceptionToThrow !== null) {
                        throw $this->exceptionToThrow;
                    }
                    return [];
                }
            };

            return $request;
        }
    }
}
