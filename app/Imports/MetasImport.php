<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Meta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MetasImport implements ToModel, WithHeadingRow
{
    protected $users; //Pegar usuarios
    public function __construct() {
        $this->users = User::select('id', 'nome_usuario')->get();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = $this->users->where('nome_usuario', $row['nome.usuario'])->first(); //Pegar o primeiro resultado a fim de otimizar a pesquisa na collection
        return new Meta([
            'user_id' => $user->id ?? null, //Exemplo
            'meta_revenda' => $row['meta_revenda'] //Exemplo
        ]);
    }
}
