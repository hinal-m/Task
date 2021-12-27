<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\InterestController;
use App\Http\Controllers\api\UserController;
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

Route::post('login', [AdminController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('list',[UserController::class,'list']);
    Route::post('store', [UserController::class,'store']);
    Route::put("update", [UserController::class, 'update']);
    Route::get("delete", [UserController::class, 'delete']);

    Route::post('logout', [AdminController::class, 'logout']);
    //interest
    Route::post('store-interest',[InterestController::class,'store']);
    Route::post('deposite-money',[InterestController::class,'deposite']);
    Route::get('list-interest',[InterestController::class,'list']);
    Route::get('list-unpaid',[InterestController::class,'getUnpaid']);
    Route::get('list-paid',[InterestController::class,'getPaid']);

});

