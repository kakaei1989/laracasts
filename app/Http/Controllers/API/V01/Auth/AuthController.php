<?php

namespace App\Http\Controllers\API\V01\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @method GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (auth()->attempt($request->only(['email', 'password']))) {
            return response()->json(auth()->user(), 200);
        };
//        return response(['failed'], 400);
        throw ValidationException::withMessages([
            'email' => 'incorrect credentials'
        ]);
    }

    /**
     * @method Post
     * @param Request $request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ]);

        resolve(UserRepository::class)->create($request);
        return response()->json([
            'message' => 'user created successfully'
        ], 201);
    }

    public function user()
    {
        return response()->json(auth()->user(), 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'logged out successfully'
        ], 200);
    }

}
