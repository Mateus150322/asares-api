<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\AuthController;

// Autenticação
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Contas
    Route::get('/contas',              [ContaController::class, 'index']);
    Route::post('/contas',             [ContaController::class, 'store']);

    // Extrato completo (todas as transações do usuário)
    Route::get('/transacoes',          [TransacaoController::class, 'all']);

    // Transações por tipo
    Route::post('/transacoes/entrada', [TransacaoController::class, 'entrada']);
    Route::post('/transacoes/saida',   [TransacaoController::class, 'saida']);

    // Transações de uma conta específica
    Route::get('/contas/{conta}/transacoes', [TransacaoController::class, 'index']);
});