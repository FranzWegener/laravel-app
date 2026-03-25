<?php

declare(strict_types=1);

namespace App\Modules\Auth\Domain\Ports;

interface AuthPort
{
    public function isLoggedIn(int $customerId): void;

    public function attemptLogin(string $email, string $password, bool $remember): bool;
}
