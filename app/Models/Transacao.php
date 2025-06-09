<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conta;
use App\Models\User;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    protected $fillable = [
        'conta_id',
        'descricao',
        'valor',
        'tipo',
        'data',
        'user_id',
    ];

    public function conta()
    {
        return $this->belongsTo(Conta::class, 'conta_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
