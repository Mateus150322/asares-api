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

    public function update(Request $request, $id)
    {
        $conta = Conta::findOrFail($id);

        $validated = $request->validate([
            'banco'         => 'sometimes|required|string|max:255',
            'agencia'       => 'sometimes|required|string',
            'numero_conta'  => 'sometimes|required|string',
            'chave_pix'     => 'nullable|string',
            'saldo_inicial' => 'sometimes|required|numeric',
        ]);

        $conta = Conta::where('user_id', auth()->id())->findOrFail($id);
        $conta->update([
            'banco'         => $validated['banco'] ?? $conta->banco,
            'agencia'       => $validated['agencia'] ?? $conta->agencia,
            'numero_conta'  => $validated['numero_conta'] ?? $conta->numero_conta,
            'chave_pix'     => $validated['chave_pix'] ?? $conta->chave_pix,
            'saldo_inicial' => $validated['saldo_inicial'] ?? $conta->saldo_inicial,
        ]);
        return response()->json($conta, 200);
    }

    public function destroy($id)
    {
        Conta::findOrFail($id)->delete();
        return response()->json(['message' => 'Conta excluída com sucesso.'], 200);
    }
}