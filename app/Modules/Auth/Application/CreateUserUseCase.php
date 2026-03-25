<?php

declare(strict_types=1);

namespace App\Modules\Auth\Application;

use App\Modules\Auth\Domain\Ports\UserRepositoryPort;

class CreateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $userRepository,
    ) {
    }

    public function execute(string $name, string $email, string $password): void
    {
        $this->userRepository->createUser($name, $email, $password);
    }
}
