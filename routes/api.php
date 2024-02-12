<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
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



Route::group(['middleware'=>'api', 'prefix'=>'auth'], function($router){
    Route::post('/register/{id}', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/perfil', [AuthController::class, 'perfil']);
    Route::post('/cadastro', [AuthController::class, 'findByCpf']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/error', [AuthController::class, 'error']);
    Route::post('/requireCod', [AuthController::class, 'codigoCadastro']);
    Route::post('/verCod/{id}', [AuthController::class, 'verificaCodigo']);
});

Route::group(['middleware'=>'jwt.auth'], function($router){
});
