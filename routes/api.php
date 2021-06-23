<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstituicaoController;
use App\Http\Controllers\Api\ConvenioController;
use App\Http\Controllers\Api\EmprestimoController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('instituicoes', [InstituicaoController::class, 'exportarInstituicoes']);

Route::get('convenios', [ConvenioController::class, 'exportarConvenios']);

Route::post('emprestimo/simular', [EmprestimoController::class, 'simular']);
