<?php

namespace App\Services;

use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ClienteService
{
    public function __construct(private ClienteRepository $clienteRepository)
    {
    }

    public function getAll(): Collection
    {
        return $this->clienteRepository->getAll();
    }

    public function create(array $data): Model
    {
        return $this->clienteRepository->create($data);
    }

    public function update(Cliente $cliente, array $data): Cliente
    {
        return $this->clienteRepository->update($cliente, $data);
    }
}
