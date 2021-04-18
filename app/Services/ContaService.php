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
        'message' => 'Conta não encontrada',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }

  /**
   * Encontra uma conta pelo numero da conta
   * @param string $numero
   * @return array
   */
  public function findByNumeroConta(string $numero): array {
    try {
      $conta = $this->repository->findContaByNumero($numero);
      if (!empty($conta)) {
        return [
          'status' => 200,
          'message' => 'Conta encontrada',
          'conta' => $conta
        ];
      }
      return [
        'status' => 400,
        'message' => 'Conta não encontrada',
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
          'message' => 'Conta criada',
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
   * Método para creditar valor em conta
   * @param array $transacao
   * @return array
   */
  public function creditoEmConta(array $transacao): array {
    $contaExist = $this->repository->findContaByNumero($transacao['numeroConta']);
    if (!empty($contaExist)) {
      $updateConta = [
        'valor' => $contaExist['valor'] + $transacao['valor'],
        'numero' => $contaExist['numero'],
      ];
      $this->update($updateConta, $contaExist['id']);
      $contaUpdated = $this->repository->findById($contaExist['id']);
      return [
        'status' => 200,
        'message' => 'Saldo atualizado',
        'conta' => $contaUpdated,
      ];
    }
    return [
      'status' => 400,
      'message' => 'Conta não encontrada',
    ];
  }

  /**
   * Método para debita valor em conta
   * @param array $transacao
   * @return array
   */
  public function debitoEmConta(array $transacao): array {
    $contaExist = $this->repository->findContaByNumero($transacao['numeroConta']);
    if (!empty($contaExist)) {
      if ($contaExist['valor'] - $transacao['valor'] > 0) {
        $updateConta = [
          'valor' => $contaExist['valor'] - $transacao['valor'],
          'numero' => $contaExist['numero'],
        ];
        $this->update($updateConta, $contaExist['id']);
        $contaUpdated = $this->repository->findById($contaExist['id']);
        return [
          'status' => 200,
          'message' => 'Saldo atualizado',
          'conta' => $contaUpdated,
        ];
      }
      return [
        'status' => 400,
        'message' => 'Saldo insuficiente',
      ];
    }
    return [
      'status' => 400,
      'message' => 'Conta não encontrada',
    ];
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
        'message' => 'Conta não encontrada',
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
        'message' => 'Conta não encontrada',
      ];
    } catch (\Throwable $th) {
      return [
        'status' => 500, 
        'message' => $th->getMessage()
      ];
    }
  }
}