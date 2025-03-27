<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
