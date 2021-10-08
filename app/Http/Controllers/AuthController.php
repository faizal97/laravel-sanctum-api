<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthController\LoginRequest;
use App\Http\Requests\AuthController\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $token = $user->createToken('appToken');

        return response([
            'status' => 'success',
            'message' => 'User created',
            'data' => [
                'token' => $token->plainTextToken,
            ],
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::query()->where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response([
                'status' => 'error',
                'message' => 'Bad Credentials',
            ], 401);
        }

        $token = $user->createToken('appToken');

        return response([
            'status' => 'success',
            'message' => 'User created',
            'data' => [
                'token' => $token->plainTextToken,
            ],
        ], 200);
    }

    public function logout()
    {
        /** @var User */
        auth()->user()->tokens()->delete();

        return response([
            'status' => 'success',
            'message' => 'Logged out',
        ]);
    }
}
