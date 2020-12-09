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
            return Commerce::ofUser($request->user()->id)->get();
        }

        return Commerce::all();
    }

    public function all(Request $request, $commerceName)
    {
        $commerce = Commerce::whereName($commerceName)->first();

        if (!$commerce) return response()->json('No commerce found');

        $res = Commerce::with(['rubros.subrubros.products'])->whereName($commerceName)->first();

        return $res;
    }

}
