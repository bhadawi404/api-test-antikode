<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// for sanctum request brand
Route::middleware('auth:sanctum')->group(function(){
    // request brand
    // request logout
});
// request Brand
Route::apiResource('/brand', BrandController::class);
Route::apiResource('/outlet', OutletController::class);
Route::apiResource('/product', ProductController::class);

