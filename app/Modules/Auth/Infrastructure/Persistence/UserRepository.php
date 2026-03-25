<?php

declare(strict_types=1);

namespace App\Modules\Auth\Infrastructure\Persistence;

use App\Modules\Auth\Domain\Ports\UserRepositoryPort;

class UserRepository implements UserRepositoryPort
{
    public function createUser(string $name, string $email, string $password): void
    {
        User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
        ]);
    }
}
