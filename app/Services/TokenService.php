<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class TokenService
{
    public function getAuthUser(Request $request): User
    {
        return $request->user();
    }

    public function createToken(Request $request, User $user): string
    {
        return $user->createToken($request->device_name)
            ->plainTextToken;
    }

    public function logoutAll(Request $request): void
    {
        $this->getAuthUser($request)
            ->tokens()
            ->delete();
    }
}
