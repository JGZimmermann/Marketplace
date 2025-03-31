<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;

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
