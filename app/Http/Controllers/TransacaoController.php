<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\Transacao;
use Illuminate\Http\Request;

class TransacaoController extends Controller
{
    /**
     * Lista todas as transações do usuário autenticado (Extrato).
     */
    public function all()
    {
        $userId = auth()->id();
        $transacoes = Transacao::where('user_id', $userId)
                               ->orderBy('data', 'desc')
                               ->get();

        return response()->json($transacoes);
    }

    /**
     * Lista transações apenas de uma conta específica.
     */
    public function index(Conta $conta)
    {
        // (Opcional) garanta que a conta pertença ao usuário:
        if ($conta->user_id !== auth()->id()) {
            abort(403, 'Conta não pertence a você.');
        }

        $transacoes = $conta->transacoes()
                           ->orderBy('data', 'desc')
                           ->get();

        return response()->json($transacoes);
    }

    /**
     * Cadastra uma transação de entrada.
     */
    public function entrada(Request $request)
    {
        return $this->storeInternal($request, 'entrada');
    }

    /**
     * Cadastra uma transação de saída.
     */
    public function saida(Request $request)
    {
        return $this->storeInternal($request, 'saida');
    }

    /**
     * Lógica interna comum a entrada/saída.
     */
    private function storeInternal(Request $request, string $tipo)
    {
        $data = $request->validate([
            'conta_id'  => 'required|exists:contas,id',
            'descricao' => 'nullable|string',
            'valor'     => 'required|numeric',
            'data'      => 'required|date',
        ]);

        $data['user_id'] = auth()->id();
        $data['tipo']    = $tipo;

        $transacao = Transacao::create($data);

        // Atualiza o saldo da conta
        $conta = $transacao->conta;
        if ($tipo === 'entrada') {
            $conta->saldo_inicial += $transacao->valor;
        } else {
            $conta->saldo_inicial -= $transacao->valor;
        }
        $conta->save();

        return response()->json([
            'mensagem'   => 'Transação cadastrada com sucesso',
            'transacao'  => $transacao,
        ], 201);
    }

    public function update(Request $request,$id)
    {
        $data = $request->validate([
            'descricao' => 'nullable|string',
            'valor'     => 'required|numeric',
            'data'      => 'required|date',
        ]);
        $transacao = Transacao::where('user_id', auth()->id())->findOrFail($id);
        $transacao->update($data);
        return response()->json($transacao, 200);
    }
    
}