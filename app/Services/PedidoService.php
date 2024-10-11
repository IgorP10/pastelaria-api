<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\Produto;
use App\Repositories\PedidoRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PedidoService
{
    public function __construct(
        private PedidoRepository $pedidoRepository,
        private ProdutoService $produtoService
    ) {
    }

    public function getAll(int $perPage, int $page): LengthAwarePaginator
    {
        return $this->pedidoRepository->getAll($perPage, $page);
    }

    public function getById(string $id): Pedido
    {
        return $this->pedidoRepository->getById($id);
    }

    public function create(array $data): Model
    {
        $data = $this->prepareData($data);
        return $this->pedidoRepository->create($data);
    }

    public function prepareData(array $data): array
    {
        $produtos = $data['produtos'];
        foreach ($produtos as $key => $produto) {
            $produtoModel = $this->produtoService->getById($produto['id']);
            $data['total'] = $this->getTotal($produto, $produtoModel);
            $data['produtos'][$key]['details'] = $produtoModel;
        }

        return $data;
    }

    private function getTotal(array $produto, Produto $produtoModel): float
    {
        $total = 0;
        $total += (float) $produtoModel->preco * $produto['quantidade'];

        return $total;
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
