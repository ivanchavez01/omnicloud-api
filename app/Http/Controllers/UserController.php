<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param LoginRequest $loginRequest
     * @return JsonResponse
     */
    public function login(LoginRequest $loginRequest): JsonResponse
    {
        $auth = Auth::attempt($loginRequest->all());

        if ($auth === false) {
            return response()->json([
                "error" => "user dont exist"
            ], 404);
        }

        $user = User::where('email', $loginRequest->post('email'))
            ->first();

        return response()->json($user);
    }
}
