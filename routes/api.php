<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Models\Commerce;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::get('/me', [LoginController::class, 'me']);
    });
});

Route::get('/commerces', function () {
    return Commerce::all();
});

Route::group(['prefix' => '/{commerceName}'], function () {

    Route::get('/all', function ($commerceName) {
        $commerce = Commerce::whereName($commerceName)->first();

        if (!$commerce) return response()->json('No commerce found');

        // ! Refactorizar usando with
        /*
        *
        $res = Commerce::with(['rubros.subrubros' => function($query) use ($commerce) {
            return $query->where('commerce_id', '=', $commerce->id)->with(['productos']);
        }])->whereName($commerceName)->first();

        return $res;
        *
        */

        $commerce->rubros = Commerce::find($commerce->id)->rubros()->orderBy('rubros.sort')->get();

        foreach ($commerce->rubros as $rubro) {
            $rubro->subrubros = Commerce::find($commerce->id)->subrubros()->where('subrubros.rubro_id', '=', $rubro->id)->orderBy('subrubros.sort')->get();

            foreach ($rubro->subrubros as $subrubro) {
                $subrubro->products = Product::with(['product_hashtags', 'product_prices'])->where([
                    ['subrubro_id', '=', $subrubro->id],
                    ['commerce_id', '=', $commerce->id],
                ])->get();
            }
        }

        return $commerce;
    });
});