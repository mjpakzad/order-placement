<?php

namespace Modules\Auth\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\API\V1\LoginRequest;
use Modules\Auth\Http\Requests\API\V1\RegisterRequest;
use Modules\Auth\Services\Auth\AuthService;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return $this->respondWithToken($result['token']);
    }

    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        if (! $token) {
            return response()->json(['error' => __('Unauthorized')], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => __('Successfully logged out')]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->authService->getTokenTTL(),

        ]);
    }
}
