<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $rsp = Auth::user();
            $rsp->commerces = Commerce::ofUser()->get();

            return response()->json($rsp);
        }

        return response()->json(['error' => 'User not found']);
    }

    public function me(Request $request)
    {
        if (Auth::user()) {
            $rsp = Auth::user();
            $rsp->commerces = Commerce::ofUser()->get();

            return response()->json($rsp);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            return response()->json(Auth::logout());
        }
    }

    /**
     * To see more Auth methods go to: vendor\laravel\framework\src\Illuminate\Support\Facades\Auth.php
     */
}