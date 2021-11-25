<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Meta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MetasImport implements ToModel, WithHeadingRow
{
    protected $users; //Pegar usuarios
    protected $meta;
    public function __construct()
    {
        $this->users = User::select('id', 'name')->get();
        $this->meta = Meta::select('data')->get();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        
        
        dd($row);
        if(strtolower($row['Colaborador']) === null) {
            return;
        } 

         //Pegar o primeiro resultado a fim de otimizar a pesquisa na collection
        $user = $this->users->where('name', $row['colaborador'])->first();
        if($user === null) {
            return;
        }         
        
        $meta = $this->meta->where('data', date('d/m/Y'))->first();
        if($meta !== null) {
            return;
        }

        

        return new Meta([
            'user_id' => $user->id, //Exemplo
            'nome_colaborador' => $row['colaborador'], //Exemplo
            'manipulacao' => $row['manipulacao'], //Exemplo
            'revenda' => $row['revenda'], //Exemplo
            'vendas_ontem' => $row['vendas_ontem'],
            'vendas_total_manipulacao' => $row['venda_total_manip'],
            'data' => date('d/m/Y')
        ]);
    }
}

