<?php

declare(strict_types=1);

namespace App\Modules\Auth\Infrastructure\Laravel;

use App\Modules\Auth\Domain\Ports\AuthPort;
use Illuminate\Support\Facades\Auth;

class LaravelAuthAdapter implements AuthPort
{
    public function isLoggedIn(int $customerId): void
    {
        if (Auth::id() != $customerId) {
            abort(403);
        }
    }

    public function attemptLogin(string $email, string $password, bool $remember): bool
    {
        return Auth::attempt(['email' => $email, 'password' => $password], $remember);
    }
}
