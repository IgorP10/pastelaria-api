<?php

namespace App\Repositories;

use App\Models\Pedido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class PedidoRepository
{
    public function getAll(): Collection
    {
        return Pedido::all();
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
}
