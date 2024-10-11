<?php

namespace App\Services;

use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ClienteService
{
    public function __construct(private ClienteRepository $clienteRepository)
    {
    }

    public function getAll(int $perPage, int $page): LengthAwarePaginator
    {
        return $this->clienteRepository->getAll($perPage, $page);
    }

    public function getById(string $id): Cliente
    {
        return $this->clienteRepository->getById($id);
    }

    public function create(array $data): Model
    {
        return $this->clienteRepository->create($data);
    }

    public function update(Cliente $cliente, array $data): Cliente
    {
        return $this->clienteRepository->update($cliente, $data);
    }

    public function delete(string $id): void
    {
        $this->clienteRepository->delete($id);
    }
}
