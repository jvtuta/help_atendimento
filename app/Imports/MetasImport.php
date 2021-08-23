<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Meta;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MetasImport implements ToModel, WithHeadingRow
{
    protected $users; //Pegar usuarios
    public function __construct()
    {
        $this->users = User::select('id', 'name')->get();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if($row['colaborador'] === null) {
            return;
        } 

         //Pegar o primeiro resultado a fim de otimizar a pesquisa na collection
         $user = $this->users->where('name', $row['colaborador'])->first();
         if($user === null) {
            return;
         }
         
        return new Meta([
            'user_id' => $user->id, //Exemplo
            'nome_colaborador' => $row['colaborador'], //Exemplo
            'manipulacao' => $row['manipulacao'], //Exemplo
            'revenda' => $row['revenda'], //Exemplo
            'vendas_ontem' => $row['vendas_ontem'],
            'vendas_total_manipulacao' => $row['venda_total_manip']
        ]);
    }
}
