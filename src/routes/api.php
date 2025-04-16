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
use App\Http\Controllers\DiscountController;

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
    ->middleware('auth:sanctum', 'check.user.role.admin');

//Rotas para Endereço
Route::get('/addresses', [AddressController::class, 'showByUser'])
    ->middleware('auth:sanctum');
Route::post('/addresses',[AddressController::class, 'store'])
    ->middleware('auth:sanctum');
Route::get('/addresses/{id}',[AddressController::class, 'show'])
    ->middleware('auth:sanctum', 'check.user.role.address');
Route::patch('/addresses/{id}',[AddressController::class, 'update'])
    ->middleware('auth:sanctum', 'check.user.role.address');
Route::delete('/addresses/{id}',[AddressController::class, 'delete'])
    ->middleware('auth:sanctum', 'check.user.role.address');

//Rotas para Categoria
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store'])
    ->middleware('auth:sanctum', 'check.user.role');
Route::patch('/categories/{id}', [CategoryController::class, 'update'])
    ->middleware('auth:sanctum', 'check.user.role');
Route::delete('/categories/{id}', [CategoryController::class, 'delete'])
    ->middleware('auth:sanctum', 'check.user.role');

//Rotas para Produtos
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/category/{id}', [ProductController::class, 'showByCategory']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store'])
    ->middleware('auth:sanctum', 'check.user.role');
Route::patch('/products/{id}', [ProductController::class, 'update'])
    ->middleware('auth:sanctum', 'check.user.role');
Route::patch('/products/{id}/stock', [ProductController::class, 'updateStock'])
    ->middleware('auth:sanctum', 'check.user.role');
Route::delete('/products/{id}', [ProductController::class, 'delete'])
    ->middleware('auth:sanctum', 'check.user.role');

//Rotas para Cupons
Route::get('/coupons', [CouponController::class, 'index']);
Route::get('/coupons/{id}', [CouponController::class, 'show']);
Route::post('/coupons', [CouponController::class, 'store'])
    ->middleware('auth:sanctum', 'check.user.role' );
Route::patch('/coupons/{id}', [CouponController::class, 'update'])
    ->middleware('auth:sanctum', 'check.user.role' );
Route::delete('/coupons/{id}', [CouponController::class, 'delete'])
    ->middleware('auth:sanctum', 'check.user.role');

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
    ->middleware('auth:sanctum', 'check.user.role.order');
Route::post('/orders', [OrderController::class, 'store'])
    ->middleware('auth:sanctum');
Route::patch('/orders/{id}', [OrderController::class, 'update'])
    ->middleware('auth:sanctum', 'check.user.role.order');
Route::delete('/orders/{id}', [OrderController::class, 'cancel'])
    ->middleware('auth:sanctum', 'check.user.role.order');

//Rotas para Descontos
Route::get('/discounts', [DiscountController::class, 'index']);
Route::get('/discounts/{id}', [DiscountController::class, 'show']);
Route::post('/discounts', [DiscountController::class, 'store'])
    ->middleware('auth:sanctum', 'check.user.role.discount');
Route::patch('/discounts/{id}', [DiscountController::class, 'update'])
    ->middleware('auth:sanctum', 'check.user.role.discount');
Route::delete('/discounts/{id}', [DiscountController::class, 'delete'])
    ->middleware('auth:sanctum', 'check.user.role.discount');
