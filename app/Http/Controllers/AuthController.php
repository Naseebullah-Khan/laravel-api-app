<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterPostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterPostRequest $request): array
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        $token = $user->createToken(name: $request->name, expiresAt: now()->addMinutes(value: 30));

        return [
            "user" => $user,
            "token" => $token->plainTextToken
        ];
    }

    public function login(LoginPostRequest $request): array
    {
        $user = User::where(column: "email", operator: "=", value: $request->email)->first();

        if (!$user || !Hash::check(value: $request->password, hashedValue: $user->password)) {
            return [
                "errors" => [
                    "email" => "The provided credentials are incorrect."
                ]
            ];
        }

        $token = $user->createToken(name: $user->name, expiresAt: now()->addMinutes(value: 30));

        return [
            "user" => $user,
            "token" => $token->plainTextToken
        ];
    }

    public function logout(Request $request): array
    {
        $request->user()->tokens()->delete();
        return [
            "Logout!" => "You are logged out!"
        ];
    }
}
