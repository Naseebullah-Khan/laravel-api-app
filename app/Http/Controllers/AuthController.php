<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterPostRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterPostRequest $request): array
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        $token = $user->createToken(name: $request->name);

        return [
            "user" => $user,
            "token" => $token->plainTextToken
        ];
    }

    public function login(LoginPostRequest $request): string
    {
        return "Login!";
    }

    public function logout(Request $request): string
    {
        return "Logout!";
    }
}
