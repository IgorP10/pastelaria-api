<?php

namespace App\Repositories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClienteRepository
{
    public function getAll(int $perPage, $page): LengthAwarePaginator
    {
        return Cliente::with('pedidos')->paginate(
            $perPage,
            ['*'],
            'page',
            $page
        );
    }

    public function getById(string $id): Cliente
    {
        return Cliente::with('pedidos')->findOrFail($id);
    }

    public function create(array $data): Cliente
    {
        return Cliente::create($data);
    }

    public function update(Cliente $cliente, array $data): Cliente
    {
        $cliente->update($data);

        return $cliente;
    }

    public function delete(Cliente $cliente): void
    {
        $cliente->delete();
    }
}
