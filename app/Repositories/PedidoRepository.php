<?php

namespace App\Repositories;

use App\Models\Pedido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PedidoRepository
{
    public function getAll(int $perPage, int $page): LengthAwarePaginator
    {
        return Pedido::with('cliente')->paginate(
            $perPage,
            ['*'],
            'page',
            $page
        );
    }

    public function getById(string $id): Pedido
    {
        return Pedido::with('cliente')->findOrFail($id);
    }

    public function create(array $data): Pedido
    {
        $pedido = Pedido::create($data);
        $pedido->load('cliente');

        return $pedido;
    }

    public function update(Pedido $pedido, array $data): Pedido
    {
        $pedido->update($data);

        return $pedido;
    }

    public function delete(Pedido $pedido): void
    {
        $pedido->delete();
    }
}
