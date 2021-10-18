<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\TokenRequest;
use App\Services\TokenService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private TokenService $tokenService;
    private UserService $userService;

    public function __construct(TokenService $tokenService, UserService $userService)
    {
        $this->tokenService = $tokenService;
        $this->userService = $userService;
    }
    public function register(RegisterRequest $request)
    {
        $user = $this->userService->store($request);
        $token = $this->tokenService->createToken($request, $user);

        return response()
            ->json([
                'user' => $user,
                'token' => $token,
            ]);
    }

    public function token(TokenRequest $request)
    {
        $user = $this->userService->login($request);
        $token = $this->tokenService->createToken($request, $user);

        return response()
            ->json([
                'user' => $user,
                'token' => $token,
            ]);
    }

    public function me(Request $request)
    {
        return $this->tokenService->getAuthUser($request);
    }

    public function logout(Request $request)
    {
        $this->tokenService->logoutAll($request);
    }
}
