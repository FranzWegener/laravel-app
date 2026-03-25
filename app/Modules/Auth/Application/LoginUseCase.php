<?php

declare(strict_types=1);

namespace App\Modules\Auth\Application;

use App\Modules\Auth\Domain\Ports\AuthPort;

class LoginUseCase
{
    public function __construct(
        private readonly AuthPort $authPort,
    ) {
    }

    public function execute(string $email, string $password, bool $remember): bool
    {
        return $this->authPort->attemptLogin($email, $password, $remember);
    }
}
