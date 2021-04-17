<?php

namespace App\Repositories;

use App\Models\Transacao;
use App\Repositories\Contract\TransacaoRepositoryInterface;

class TransacaoRepository implements TransacaoRepositoryInterface{

    private Transacao $transacao;

    public function __construct(Transacao $transacao)
    {
      $this->transacao = $transacao;  
    }
    /**
     * Recebe um ID e retorna uma transacao
     * @param int $id
     * @return array
     */
    public function findById(int $id) {
        return $this->transacao->find($id);
    }

    /**
     * Retorna todas as transacoes
     * @return array
     */
    public function findAll() {
        return $this->transacao->paginate();
    }

    /**
     * Cria uma transacao e retorna
     * @param array $transacao
     * @return array
     */
    public function create(array $transacao) {
        return $this->transacao->create($transacao);
    }

     /**
     * Recebe um ID e remove a transacao
     * @param int $id
     * @return boolean
     */
    public function delete(int $id) {
        return $this->transacao->find($id)->delete();
    }
}