<?php

namespace App\Services;

use App\Jobs\SendPedidoEmail;
use App\Models\Pedido;
use App\Models\Produto;
use App\Repositories\PedidoRepository;
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

    public function create(array $data): Pedido
    {
        $data = $this->prepareData($data);
        $pedido = $this->pedidoRepository->create($data);

        $this->triggerJobToSendEmail($pedido);

        return $pedido;
    }

    public function prepareData(array $data): array
    {
        $produtos = $data['produtos'];
        $data['total'] = 0;
        foreach ($produtos as $key => $produto) {
            $produtoModel = $this->produtoService->getById($produto['id']);
            $data['total'] += $this->getTotal($produto, $produtoModel);
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

    public function update(string $id, array $data): Pedido
    {
        $pedido = $this->getById($id);
        $data = $this->prepareData($data);
        $pedidoUpdated = $this->pedidoRepository->update($pedido, $data);
        $this->triggerJobToSendEmail($pedido);

        return $pedidoUpdated;
    }

    public function delete(string $id): void
    {
        $pedido = $this->getById($id);
        $this->pedidoRepository->delete($pedido);
    }

    private function triggerJobToSendEmail(Pedido $pedido): void
    {
        SendPedidoEmail::dispatch($pedido);
    }
}
