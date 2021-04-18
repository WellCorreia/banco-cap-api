<?php

namespace App\Services;

use App\Repositories\TransacaoRepository;
use App\Services\Contract\TransacaoServiceInterface;
use App\Services\ContaService;
use DB;

class TransacaoService implements TransacaoServiceInterface
{
  protected TransacaoRepository $repository;
  protected ContaService $contaService;

  public function __construct(TransacaoRepository $transacaoRepository, ContaService $contaService)
  {
    $this->repository = $transacaoRepository;
    $this->contaService = $contaService;
  }

  /**
   * Retorna todas as transacoes
   * @return array
   */
  public function findAll(): array {
    try {
      $transacoes = $this->repository->findAll();
      return [
        'status' => 200,
        'message' => 'Transações Encontradas',
        'transacoes' => $transacoes
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500,
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Encontra uma transacao pelo ID
   * @param int $id
   * @return array
   */
  public function findById(int $id): array {
    try {
      $transacao = $this->repository->findById($id);
      if (!empty($transacao)) {
        return [
          'status' => 200,
          'message' => 'Transação encontrada',
          'transacao' => $transacao
        ];
      }
      return [
        'status' => 400,
        'message' => 'Transação não encontrada',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Cria uma transacao
   * @param array $transacao
   * @return array
   */
  public function create(array $transacao): array {
    return DB::transaction(function () use ($transacao){
      try {
        $contaExist = $this->contaService->findByNumeroConta($transacao['numeroConta']);
        if ($contaExist['status'] == 200) {
          $transactionResult = null;
          if ($transacao['tipo'] == 'saque') {
            $transactionResult = $this->contaService->debitoEmConta($transacao);
          } else {
            $transactionResult = $this->contaService->creditoEmConta($transacao);
          }
          $transacao['conta_id'] = $contaExist['conta']['id'];
          $this->repository->create($transacao);
          DB::commit();
          return $transactionResult;
        }
        return $contaExist;

      } catch (\Throwable $th) {
        DB::rollback();
        dd($th->getMessage());
        return [
          'status' => 500, 
          'message' => $th->getMessage()
        ];
      } 
    });
  }

  /**
   * Remove uma transacao pelo ID
   * @param int $id
   * @return array
   */
  public function delete(int $id): array {
    try {
      $transacao = $this->repository->findById($id);
      if (!empty($transacao)) {
        $this->repository->delete($id);
        return [
          'status' => 200,
          'message' => 'Transação removida',
        ];
      }
      return [
        'status' => 400,
        'message' => 'Transação não encontrada',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }
}