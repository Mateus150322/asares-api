<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    // Lista todas as contas do usuário autenticado
    public function index()
    {
        $contas = Conta::where('user_id', auth()->id())->get();
        return response()->json($contas);
    }

    // Cria nova conta
    public function store(Request $request)
    {
        $validated = $request->validate([
            'banco'         => 'required|string|max:255',
            'agencia'       => 'required|string',
            'numero_conta'  => 'required|string',
            'chave_pix'     => 'nullable|string',
            'saldo_inicial' => 'required|numeric',
        ]);

        $conta = Conta::create([
            'banco'         => $validated['banco'],
            'agencia'       => $validated['agencia'],
            'numero_conta'  => $validated['numero_conta'],
            'chave_pix'     => $validated['chave_pix'] ?? null,
            'saldo_inicial' => $validated['saldo_inicial'],
            'user_id'       => auth()->id(),
        ]);

        return response()->json($conta, 201);
    }

    // demais métodos: update, destroy...
}