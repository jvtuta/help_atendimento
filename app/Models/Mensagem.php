<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{

    use HasFactory;
    public $timestamps = true;

    protected $table = 'mensagens';
    protected $fillable = ['desc_mensagem','de_user_id','para_user_id'];
    // user_id = remetente = de_usuario
    public function user() {
        return $this->belongsTo('App\Models\User','para_user_id');
    }

}
