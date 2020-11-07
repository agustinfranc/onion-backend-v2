<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'nullable',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'User not found'], 401);
        }

        $user = User::find(Auth::user()->id);
        $user->commerces = Commerce::ofUser()->get();
        $user->token = $user->createToken($request->device_name ?? 'token-name')->plainTextToken;

        return response()->json($user);
    }

    public function me(Request $request)
    {
        if (!Auth::user()) {
            return response()->json(['error' => 'error']);
        }

        $rsp = Auth::user();
        $rsp->commerces = Commerce::ofUser()->get();

        return response()->json($rsp);
    }

    public function logout(Request $request)
    {
        if (!Auth::user()) {
            return response()->json(['error' => 'error']);
        }

        $user = User::find(Auth::user()->id);
        if ($user->currentAccessToken()) $user->currentAccessToken()->delete();

        return response()->json(Auth::logout());
    }

    /**
     * To see more Auth methods go to: vendor\laravel\framework\src\Illuminate\Support\Facades\Auth.php
     */
}
