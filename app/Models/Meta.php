<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nome_colaborador',
        'manipulacao',
        'revenda',
        'vendas_ontem',
        'vendas_total_manipulacao',
        'data'
    ];
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
