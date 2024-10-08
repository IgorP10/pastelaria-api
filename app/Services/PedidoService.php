<?php

namespace App\Services;

use App\Models\Pedido;
use App\Repositories\PedidoRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class PedidoService
{
    public function __construct(private PedidoRepository $pedidoRepository)
    {
    }

    public function getAll(): Collection
    {
        return $this->pedidoRepository->getAll();
    }

    public function getById(string $id): Pedido
    {
        return $this->pedidoRepository->getById($id);
    }

    public function create(array $data): Model
    {
        return $this->pedidoRepository->create($data);
    }

    public function update(Pedido $pedido, array $data): Pedido
    {
        return $this->pedidoRepository->update($pedido, $data);
    }

    public function delete(string $id): void
    {
        $this->pedidoRepository->delete($id);
    }
}
