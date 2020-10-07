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
        if (Auth::user()) {
            return Commerce::ofUser()->get();
        }

        return Commerce::all();
    }


}
