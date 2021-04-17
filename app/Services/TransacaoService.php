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
        'message' => 'Transacaos Encontradas',
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
          'message' => 'Transacao encontrada',
          'transacao' => $transacao
        ];
      }
      return [
        'status' => 400,
        'message' => 'Não encontrada',
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
        if ($transacao['tipo'] == 'saque') {
          $saque = $this->contaService->debitoEmConta($transacao);
          DB::commit();
          return $saque;
        } else {
          $deposito = $this->contaService->creditoEmConta($transacao);
          DB::commit();
          return $deposito;
        }
      } catch (\Throwable $th) {
        DB::rollback();
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
          'message' => 'Transacao removida',
        ];
      }
      return [
        'status' => 400,
        'message' => 'Não encontrada',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }
}