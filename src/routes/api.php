<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Rotas para Login
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth:sanctum');

//Rotas do usuário autenticado
Route::get('/users/me', [UserController::class, 'loggedUser'])
    ->middleware('auth:sanctum');
Route::patch('/users/me', [UserController::class, 'update'])
    ->middleware('auth:sanctum');
Route::delete('/users/me', [UserController::class, 'delete'])
    ->middleware('auth:sanctum');

//Rota para criar moderador
Route::post('/users/create-moderator', [UserController::class, 'registerModerator'])
    ->middleware('auth:sanctum');

//Rotas para Endereço
Route::get('/addresses', [AddressController::class, 'showByUser'])
    ->middleware('auth:sanctum');
Route::post('/addresses',[AddressController::class, 'store'])
    ->middleware('auth:sanctum');
Route::get('/addresses/{id}',[AddressController::class, 'show'])
    ->middleware('auth:sanctum');
Route::patch('/addresses/{id}',[AddressController::class, 'update'])
    ->middleware('auth:sanctum');
Route::delete('/addresses/{id}',[AddressController::class, 'delete'])
    ->middleware('auth:sanctum');

//Rotas para Categoria
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store'])
    ->middleware('auth:sanctum');
Route::patch('/categories/{id}', [CategoryController::class, 'update'])
    ->middleware('auth:sanctum');
Route::delete('/categories/{id}', [CategoryController::class, 'delete'])
    ->middleware('auth:sanctum');

//Rotas para Produtos
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/category/{id}', [ProductController::class, 'showByCategory']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store'])
    ->middleware('auth:sanctum');
Route::patch('/products/{id}', [ProductController::class, 'update'])
    ->middleware('auth:sanctum');
Route::patch('/products/{id}/stock', [ProductController::class, 'updateStock'])
    ->middleware('auth:sanctum');
Route::delete('/products/{id}', [ProductController::class, 'delete'])
    ->middleware('auth:sanctum');

//Rotas para Cupons
Route::get('/coupons', [CouponController::class, 'index']);
Route::get('/coupons/{id}', [CouponController::class, 'show']);
Route::post('/coupons', [CouponController::class, 'store'])
    ->middleware('auth:sanctum');
Route::patch('/coupons/{id}', [CouponController::class, 'update'])
    ->middleware('auth:sanctum');
Route::delete('/coupons/{id}', [CouponController::class, 'delete'])
    ->middleware('auth:sanctum');

//Rotas para Carrinho
Route::get('/cart', [CartController::class, 'index'])
    ->middleware('auth:sanctum');
Route::post('/cart',[CartController::class, 'store'])
    ->middleware('auth:sanctum');

//Rotas para Item do Carrinho
Route::get('/cart/items', [CartItemController::class, 'index'])
    ->middleware('auth:sanctum');
Route::post('/cart/items', [CartItemController::class, 'store'])
    ->middleware('auth:sanctum');
Route::patch('/cart/items', [CartItemController::class, 'update'])
    ->middleware('auth:sanctum');
Route::delete('/cart/items', [CartItemController::class, 'delete'])
    ->middleware('auth:sanctum');
Route::delete('/cart/clear', [CartItemController::class, 'clear'])
    ->middleware('auth:sanctum');

//Rotas para Pedidos
Route::get('/orders', [OrderController::class, 'index'])
    ->middleware('auth:sanctum');
Route::get('/orders/{id}', [OrderController::class, 'show'])
    ->middleware('auth:sanctum');
Route::post('/orders', [OrderController::class, 'store'])
    ->middleware('auth:sanctum');
Route::patch('/orders/{id}', [OrderController::class, 'update'])
    ->middleware('auth:sanctum');
Route::delete('/orders/{id}', [OrderController::class, 'cancel'])
    ->middleware('auth:sanctum');
