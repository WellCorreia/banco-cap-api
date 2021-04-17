<?php

namespace App\Services;

use App\Repositories\ContaRepository;
use App\Services\Contract\ContaServiceInterface;

class ContaService implements ContaServiceInterface
{
  protected $repository;

  public function __construct(ContaRepository $contaRepository)
  {
    $this->repository = $contaRepository;
  }

  /**
   * Retorna todas as contas
   * @return array
   */
  public function findAll(): array {
    try {
      $contas = $this->repository->findAll();
      return [
        'status' => 200,
        'message' => 'Contas Encontradas',
        'contas' => $contas
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500,
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Encontra uma conta pelo ID
   * @param int $id
   * @return array
   */
  public function findById(int $id): array {
    try {
      $conta = $this->repository->findById($id);
      if (!empty($conta)) {
        return [
          'status' => 200,
          'message' => 'Conta encontrada',
          'conta' => $conta
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
   * Cria uma conta
   * @param array $conta
   * @return array
   */
  public function create(array $conta): array {
    try {
      $contaExist = $this->repository->findContaByNumero($conta['numero']);
      if ($conta['valor'] < 0) {
        return [
          'status' => 400,
          'message' => 'Não permitido criar conta com valor menor que zero',
        ];
      }
      if (empty($contaExist)) {
        $conta = $this->repository->create($conta);
        return [
          'status' => 201,
          'message' => 'Created conta',
          'conta' => $conta
        ];
      }
      return [
        'status' => 400,
        'message' => 'Conta já existente',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Atualiza uma conta
   * @param array $conta
   * @param int $id
   * @return array
   */
  public function update(array $conta, int $id): array {
    try {
      $contaExist = $this->repository->findById($id);
      if (!empty($contaExist)) {
        $conta = $this->repository->update($conta, $id);
        return [
          'status' => 200,
          'message' => 'Conta atualizada',
          'conta' => $conta
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
   * Remove uma conta pelo ID
   * @param int $id
   * @return array
   */
  public function delete(int $id): array {
    try {
      $conta = $this->repository->findById($id);
      if (!empty($conta)) {
        $this->repository->delete($id);
        return [
          'status' => 200,
          'message' => 'Conta removida',
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