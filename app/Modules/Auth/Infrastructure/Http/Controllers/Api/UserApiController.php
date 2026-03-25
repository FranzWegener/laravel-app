<?php

declare(strict_types=1);

namespace App\Modules\Auth\Infrastructure\Http\Controllers\Api;

use App\Modules\Auth\Application\CreateUserUseCase;
use App\Shared\Infrastructure\Http\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends BaseController
{
    public function __construct(
        private readonly CreateUserUseCase $createUserUseCase,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $this->createUserUseCase->execute($request->name, $request->email, $request->password);

        return new JsonResponse(['message' => 'User created successfully.'], 201);
    }
}
