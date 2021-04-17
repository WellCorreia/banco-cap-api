<?php

namespace App\Services\Contract;


interface TransacaoServiceInterface
{
  public function findAll(): array;
  public function findById(int $id): array;
  public function create(array $transacao): array;
  public function delete(int $id): array;
}