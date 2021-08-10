<?php
namespace App\Repository;

// use App\Repositories\Repository;

class UserRepository extends Repository 
{
    // criar algoritmo para pesquisar as mensagens da coluna 'para_user_id'

    
    public function getMensagem($user) {
        $user = str_replace('de_user_id=','',$user);
        $user = explode(';',$user);
        $this->repository = $this->repository->join('mensagens','users.id', '=', 'mensagens.de_user_id')
            ->where('mensagens.de_user_id','=', $user[0])
            ->where('mensagens.para_user_id', '=', $user[1])
            ->orWhere('mensagens.de_user_id','=',$user[1])
            ->where('mensagens.para_user_id', '=', $user[0])
            ->orderBy('mensagens.id', 'desc');
    }
}