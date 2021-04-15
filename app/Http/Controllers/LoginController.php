<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'nullable',
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['error' => 'Usuario y/o contraseña incorrectos'], 401);
        }

        $user->commerces = Commerce::ofUser($user)->get();
        $user->token = $user->createToken($validatedData['device_name'] ?? 'token-name')->plainTextToken;

        return response()->json($user);
    }

    public function me(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'error']);
        }

        $rsp = $request->user();
        $rsp->commerces = Commerce::ofUser($request->user())->get();

        return response()->json($rsp);
    }

    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'error']);
        }

        $user = User::find($request->user()->id);
        if ($user->currentAccessToken()) $user->currentAccessToken()->delete();

        return response()->json($request->user()->currentAccessToken()->delete());
    }

    /**
     * To see more Auth methods go to: vendor\laravel\framework\src\Illuminate\Support\Facades\Auth.php
     */
}
