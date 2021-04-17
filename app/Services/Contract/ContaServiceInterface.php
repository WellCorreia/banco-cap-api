<?php

namespace App\Services\Contract;


interface ContaServiceInterface
{
  public function findAll(): array;
  public function findById(int $id): array;
  public function create(array $conta): array;
  public function update(array $user, int $id): array;
  public function delete(int $id);
}