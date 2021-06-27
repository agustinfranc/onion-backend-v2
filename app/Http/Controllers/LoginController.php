<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
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
    public function authenticate(Request $request, UserRepository $repository)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'nullable',
        ]);

        $user = $repository->getByEmail($validatedData['email']);

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['error' => 'Usuario y/o contraseña incorrectos'], 401);
        }

        $user = $repository->getOne($user);

        return $user;
    }

    public function me(Request $request, UserRepository $repository)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'error']);
        }

        $user = $repository->getOne($request->user());

        return $user;
    }

    public function logout(Request $request)
    {
        if (!$request->user()->currentAccessToken()) {
            return true;
        }

        return response()->json($request->user()->currentAccessToken()->delete());
    }

    /**
     * To see more Auth methods go to: vendor\laravel\framework\src\Illuminate\Support\Facades\Auth.php
     */
}
