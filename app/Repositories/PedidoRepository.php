<?php

namespace App\Repositories;

use App\Models\Pedido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PedidoRepository
{
    public function getAll(): Collection
    {
        $pedidos = Pedido::all();

        if ($pedidos->isEmpty()) {
            throw new ModelNotFoundException('Nenhum pedido encontrado');
        }

        return $pedidos;
    }

    public function getById(string $id): Pedido
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            throw new ModelNotFoundException('Pedido não encontrado');
        }

        return $pedido;
    }

    public function create(array $data): Model
    {
        return Pedido::create($data);
    }

    public function update(Pedido $pedido, array $data): Pedido
    {
        $pedido->update($data);

        return $pedido;
    }

    public function delete(string $id): void
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            throw new ModelNotFoundException('Pedido não encontrado');
        }

        $pedido->delete();
    }
}
