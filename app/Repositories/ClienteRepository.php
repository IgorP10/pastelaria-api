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
        $clientes = Cliente::with('pedidos')->paginate(
            $perPage,
            ['*'],
            'page',
            $page
        );

        if ($clientes->isEmpty()) {
            throw new ModelNotFoundException('Nenhum cliente encontrado');
        }

        return $clientes;
    }

    public function getById(string $id): Cliente
    {
        $cliente = Cliente::with('pedidos')->find($id);

        if (!$cliente) {
            throw new ModelNotFoundException('Cliente não encontrado');
        }

        return $cliente;
    }

    public function create(array $data): Model
    {
        return Cliente::create($data);
    }

    public function update(Cliente $cliente, array $data): Cliente
    {
        $cliente->update($data);

        return $cliente;
    }

    public function delete(string $id): void
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            throw new ModelNotFoundException('Cliente não encontrado');
        }

        $cliente->delete();
    }
}
