<?php

declare(strict_types=1);

namespace App\Modules\Auth\Infrastructure\Http\Controllers\Api;

use App\Modules\Auth\Application\LoginUseCase;
use App\Shared\Infrastructure\Http\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginApiController extends BaseController
{
    public function __construct(
        private readonly LoginUseCase $loginUseCase,
    ) {
    }

    public function login(Request $request): JsonResponse
    {
        $email = $request->validate(['email' => ['required', 'email']])['email'];
        $password = $request->validate(['password' => ['required']])['password'];

        if ($this->loginUseCase->execute($email, $password, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            return new JsonResponse([
                'id' => $user->id,
                'email' => $user->email,
            ]);
        }

        return new JsonResponse([
            'errors' => ['email' => ['Die eingegebenen Zugangsdaten sind ungültig.']],
        ], 422);
    }
}
