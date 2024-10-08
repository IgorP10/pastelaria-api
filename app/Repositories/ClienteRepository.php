<?php

namespace App\Repositories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClienteRepository
{
    public function getAll(): Collection
    {
        $clientes = Cliente::all();

        if ($clientes->isEmpty()) {
            throw new ModelNotFoundException('Nenhum cliente encontrado');
        }

        return $clientes;
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
}
