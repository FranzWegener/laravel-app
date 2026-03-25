<?php

declare(strict_types=1);

namespace App\Modules\Auth\Domain\Ports;

interface UserRepositoryPort
{
    public function createUser(string $name, string $email, string $password): void;
}
