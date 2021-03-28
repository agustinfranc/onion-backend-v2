<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GetCombos extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $combos = explode(',', request()->query('combos'));

        $response = [];

        foreach($combos as $combo) {
            $model = 'App\\Models\\' . Str::studly(Str::singular($combo));

            if(!class_exists($model)) continue;

            $response[$combo] = $model::all();
        }

        return response()->json($response);
    }
}
