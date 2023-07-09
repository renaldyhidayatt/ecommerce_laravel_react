<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});


Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/categories/slug/{slug}', [CategoryController::class, 'showBySlug']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/{slug}', [ProductController::class, 'showBySlug']);


Route::middleware('auth:api')->group(function () {
    Route::post('/categories', [CategoryController::class, 'store'], 'CategoryController@store');
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::put('/products/update-quantity', [ProductController::class, 'updateQuantity']);
    Route::delete('/products/{id}', [ProductController::class, 'destory']);


    Route::get('/orders/export-excel', [OrderController::class, 'exportExcel']);
    Route::get('/orders/find-by-user/{id}', [OrderController::class, 'findByUserId']);
    Route::post('/orders/create', [OrderController::class, 'createOrder']);
    Route::get('/orders', [OrderController::class, 'findAll']);
    Route::delete('/orders/delete/{id}', [OrderController::class, 'deleteOrder']);
    Route::get('/orders/generate-pdf', [OrderController::class, 'generatePdf']);

    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);


    // Route::apiResource('/sliders', 'App\Http\Controller\SliderController');

    Route::get('/sliders', [SliderController::class, 'index']);
    Route::get('/sliders/{id}', [SliderController::class, 'show']);
    Route::post('/sliders', [SliderController::class, 'create']);
    Route::post('/sliders/{id}', [SliderController::class, 'update']);

    Route::delete('/sliders/{id}', [SliderController::class, 'delete']);


    Route::get('/users', [UserController::class, 'findAll']);
    Route::get('/users/{id}', [UserController::class, 'findById']);
    Route::post('/users', [UserController::class, 'create']);
    Route::post('/users/{id}', [UserController::class, 'updateById']);
    Route::delete('/users/{id}', [UserController::class, 'deleteById']);
});
