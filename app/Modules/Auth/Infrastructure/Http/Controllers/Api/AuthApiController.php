<?php

declare(strict_types=1);

namespace App\Modules\Auth\Infrastructure\Http\Controllers\Api;

use App\Shared\Infrastructure\Http\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends BaseController
{
    public function me(): JsonResponse
    {
        $user = Auth::user();

        return new JsonResponse([
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return new JsonResponse(['redirectTo' => '/app/login']);
    }
}
