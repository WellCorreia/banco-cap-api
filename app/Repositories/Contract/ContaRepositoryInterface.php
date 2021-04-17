<?php

namespace App\Repositories\Contract;


interface ContaRepositoryInterface
{
  public function findAll();
  public function findById(int $id);
  public function create(array $conta);
  public function update(array $user, int $id);
  public function delete(int $id);
  public function findContaByNumero(string $numero);
}