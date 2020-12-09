<?php

use App\Http\Controllers\CommerceController;
use App\Http\Controllers\GetCombos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RubroController;

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

Route::post('/token', [LoginController::class, 'authenticate'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::get('/me', [LoginController::class, 'me'])->name('me');

        Route::apiResource('commerces', CommerceController::class)->only([
            'index'
        ]);

        Route::apiResource('commerces.products', ProductController::class)->shallow();

        Route::post('/products/{product}/upload', [ProductController::class, 'upload'])->name('products.upload');

        Route::apiResource('rubros', RubroController::class);

        Route::get('/combos', GetCombos::class)->name('combos');
    });


});

Route::get('/commerces', [CommerceController::class, 'index']);

Route::group(['prefix' => '/{commerceName}'], function () {

    Route::get('/', [CommerceController::class, 'all']);

    Route::get('/all', [CommerceController::class, 'all'])->name('all');
});
