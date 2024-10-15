<?php

namespace App\Services;

use App\Models\Cliente;
use App\Repositories\ClienteRepository;
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

    public function create(array $data): Cliente
    {
        $data['data_nascimento'] = $this->formatDate($data['data_nascimento']);
        return $this->clienteRepository->create($data);
    }

    private function formatDate(string $date): string
    {
        return date('Y-m-d', strtotime($date));
    }

    public function update(string $id, array $data): Cliente
    {
        $cliente = $this->getById($id);
        
        return $this->clienteRepository->update($cliente, $data);
    }

    public function delete(string $id): void
    {
        $cliente = $this->getById($id);
        $this->clienteRepository->delete($cliente);
    }
}
