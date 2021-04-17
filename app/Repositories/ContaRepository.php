<?php

namespace App\Repositories;

use App\Models\Conta;
use App\Repositories\Contract\ContaRepositoryInterface;

class ContaRepository implements ContaRepositoryInterface{

    private Conta $conta;

    public function __construct(Conta $conta)
    {
      $this->conta = $conta;  
    }
    /**
     * Recebe um ID e retorna uma conta
     * @param int $id
     * @return array
     */
    public function findById(int $id) {
        return $this->conta->find($id);
    }

    /**
     * Retorna todas as contas
     * @return array
     */
    public function findAll() {
        return $this->conta->paginate();
    }

    /**
     * Encontra uma conta pelo numero dela
     * @param string $numero
     * @return array
     */
    public function findContaByNumero(string $numero) {
        return $this->conta
        ->where('numero', $numero)
        ->first();
    }
    /**
     * Cria uma conta e retorna
     * @param array $conta
     * @return array
     */
    public function create(array $conta) {
        return $this->conta->create($conta);
    }

    /**
     * Recebe uma conta e um ID e à altera
     * @param array $conta
     * @param int $id
     * @return array
     */
    public function update(array $conta, int $id) {
        return $this->conta->find($id)->update($conta);
    }

     /**
     * Recebe um ID e remove a conta
     * @param int $id
     * @return boolean
     */
    public function delete(int $id) {
        return $this->conta->find($id)->delete();
    }
}