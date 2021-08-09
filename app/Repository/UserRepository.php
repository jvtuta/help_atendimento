<?php
namespace App\Repository;

// use App\Repositories\Repository;

class UserRepository extends Repository 
{
    // criar algoritmo para pesquisar as mensagens da coluna 'para_user_id'

    
    public function getMensagem($de_user_id) {
        $de_user_id = str_replace('de_user_id=','',$de_user_id);
        $de_user_id = explode(';',$de_user_id);
        $this->repository = $this->repository->join('mensagens','users.id', '=', 'mensagens.de_user_id')
            ->where('mensagens.de_user_id','=', $de_user_id[0])
            ->orWhere('mensagens.de_user_id','=',$de_user_id[1])
            ->orderBy('mensagens.id', 'desc');
            
    }
}