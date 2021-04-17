<?php

namespace App\Repositories\Contract;


interface TransacaoRepositoryInterface
{
  public function findAll();
  public function findById(int $id);
  public function create(array $conta);
  public function delete(int $id);
}