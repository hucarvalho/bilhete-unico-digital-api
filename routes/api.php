<?php

use App\Http\Controllers\AjudaController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilheteController;
use App\Http\Controllers\CartaoController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PassageiroController;
use App\Http\Controllers\PassagemController;
use App\Http\Controllers\PedidoBilheteController;
use App\Http\Controllers\SuporteController;
use App\Http\Controllers\VotosAjudasController;
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
    Route::post('/putPassword/{id}', [AuthController::class, 'updateNewPassword']);
    Route::post('/putEmail/{id}', [AuthController::class, 'updateNewEmail']);
    Route::post('/putTelefone/{id}', [AuthController::class, 'updateNewTelefone']);
    Route::post('/recuperar', [AuthController::class, 'findByCpfRecuperar']);
    Route::post('/requireCodRecuperar', [AuthController::class, 'codigoCadastroRecuperar']);

});

    
    Route::get('/testConnection', [ApiController::class, 'testConnection']);
    Route::get('/passagens/{id}', [PassagemController::class, 'getPassagens']);
    Route::get('/compras/{id}', [PassageiroController::class, 'getCompras']);
    Route::get('/compras/{id}/{bilheteId}', [PassageiroController::class, 'getComprasByBilhete']);
    Route::get('/cartao/{id}', [PassageiroController::class, 'getCartoes']);
    Route::get('/preco', [PassageiroController::class, 'getPreco']);
    Route::get('/countCompras/{idBilhete}', [PassageiroController::class, 'countCompras']);
    Route::get('/consumo/{idCatraca}/{idBilhete}', [PassageiroController::class, 'callConsumo']);
    Route::post('/acao/{id}', [PassageiroController::class, 'storeAcao']);
    Route::get('/passagens/ativa/{idBilhete}', [PassagemController::class, 'getPassagemEmUso']);
    Route::put('/passagens/inativar/{idPassagem}', [PassagemController::class, 'inativarPassagem']);
    Route::post('/storeCartao/{id}', [CartaoController::class, 'storeCartao']);
    Route::post('/storeVoto/{id}', [VotosAjudasController::class, 'store']);
    Route::post('/storeSuporte/{id}', [PassageiroController::class, 'storeSuporte']);
    Route::get('/voto/{id}/{idAjuda}', [VotosAjudasController::class, 'getVoto']);
    Route::get('/votoPorcentagem', [VotosAjudasController::class, 'getPorcentagemVoto']);
    Route::delete('/destroyCartao/{id}', [CartaoController::class, 'destroyCartao']);
    Route::post('/searchAjuda', [AjudaController::class, 'searchAjuda']);
    Route::get('/getAjuda/{id}', [AjudaController::class, 'getAjuda']);
    Route::get('/getChat/{tituloAjuda}', [ChatController::class, 'chat']);

    Route::get('/getCartao/{id}', [CartaoController::class, 'getCartao']);
    Route::post('/insertFoto/{idPassageiro}', [PassageiroController::class, 'insertFoto']);
    Route::get('/pedidoBilhete/{passageiroId}', [PedidoBilheteController::class, 'getByPassageiroId']);
    

Route::group(['middleware'=>'jwt.auth'], function($router){
    Route::get('/bilhetes/{idPassageiro}', [BilheteController::class, 'getBilhetes']);
});
