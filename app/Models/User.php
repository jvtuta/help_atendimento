<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use App\Repository\UserRepository;

class User extends Authenticatable implements JWTSubject
{

    use HasFactory, Notifiable;

    // Rest omitted for brevity
    public $timestamps = true;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nome_usuario',
        'password',
        'nivel_usuario',
        'active',
        'id_departamento',
        'autorizado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function mensagens() {
        return $this->hasMany('App\Models\Mensagem','de_user_id');
    }

    public function departamento() {
        return $this->belongsTo('App\Models\Departamento', 'id_departamento');
    }

    public function metas() {
        return $this->hasMany('App\Models\Meta');
    }

    // public function departamento() {
    //     return $this->belongsTo('App/Models/Departamento');
    // }
}
