<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommerceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()) {
            return Commerce::ofUser($request->user())->get();
        }

        return Commerce::all();
    }


}
