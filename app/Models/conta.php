<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    protected $fillable = [
        'banco',
        'agencia',
        'numero_conta',
        'chave_pix',
        'saldo_inicial',
        'user_id',
    ];
}