<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;


abstract class Repository
{
    private $relacionamento;
    public function __construct(Model $model)
    {
        $this->repository = $model;
    }

    public function selectAtributos($atributos)
    {
        //$this->repository = 
        $this->repository = $this->repository->selectRaw($atributos);  //;
    }

    public function selectAtributosRelacionamento(...$attr)
    {
        $attr = implode(',', $attr);
            $this->repository = $this->repository->with($this->relacionamento . ':id,' . $attr);
            // $this->repository = $this->repository->with($this->relacionamento . ':'.$relacionamento.',' . $attr);
    }

    public function setRelacionamento($relacionamento)
    {
        $this->repository = $this->repository->with($relacionamento);
        $this->relacionamento = $relacionamento;
        
    }

    public function filtrarRegistros($filtro)
    {
        $filtro = explode(';', $filtro);
        foreach ($filtro as $condicao) {
            $condicao = explode(':', $condicao);
            $this->repository = $this->repository->where($condicao[0], $condicao[1], $condicao[2]);
        }
    }

    public function getRes()
    {
        return $this->repository->get();
    }
}
