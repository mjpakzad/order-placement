<?php

namespace Modules\Auth\Services\Auth;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return compact('user', 'token');
    }

    public function login(array $credentials): string|false
    {
        return auth('api')->attempt($credentials);
    }

    public function getTokenTTL(): int
    {
        return config('jwt.ttl') * 60;
    }
}
