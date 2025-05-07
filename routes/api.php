<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommerceController;
use App\Http\Controllers\GetCombos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
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

Route::middleware('guest')->group(function () {
    Route::post('/token', [LoginController::class, 'authenticate'])->name('api-login');

    Route::post('/register', [RegisterController::class, 'register'])->name('api-register');

    Route::get('/commerces', [CommerceController::class, 'index']);
    Route::get('/commerces/{commerce}', [CommerceController::class, 'show'])->whereNumber('commerce');

    Route::group(['prefix' => '/{commerceName}'], function () {
        Route::get('/', [CommerceController::class, 'showByName']);
        Route::get('/all', [CommerceController::class, 'showByName'])->name('showByName');
    });

    Route::get('/commerces/{commerce}/products', [ProductController::class, 'index'])->name('guest.products.index');

    Route::get('/products/{product}', [ProductController::class, 'show'])->name('guest.products.show');

    Route::post('/checkout/preferences', [CheckoutController::class, 'generatePreference'])->name('checkout.preferences.generatePreference');
});

Route::middleware(['auth:sanctum', 'authorized'])->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::get('/me', [LoginController::class, 'me'])->name('me');

        Route::post('/logout', [LoginController::class, 'logout'])->name('api-logout');

        Route::apiResource('commerces', CommerceController::class);

        Route::apiResource('commerces.products', ProductController::class)->shallow();

        Route::apiResource('rubros', RubroController::class);

        Route::post('/commerces/{commerce}/upload', [CommerceController::class, 'upload'])->name('commerces.upload');

        Route::post('/products/{product}/upload', [ProductController::class, 'upload'])->name('products.upload');

        Route::get('/combos', GetCombos::class)->name('combos');
    });
});
