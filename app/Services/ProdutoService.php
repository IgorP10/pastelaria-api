<?php

namespace App\Services;

use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ProdutoService
{
    public function __construct(private ProdutoRepository $produtoRepository)
    {
    }

    public function getAll(): Collection
    {
        return $this->produtoRepository->getAll();
    }

    public function getById(string $id): Produto
    {
        return $this->produtoRepository->getById($id);
    }

    public function create(array $data): Model
    {
        $data['foto'] = $this->generateImagePath($data);

        return $this->produtoRepository->create($data);
    }

    private function generateImagePath(array $data): string
    {
        return $data['foto']->store('produtos', 'public');
    }

    public function update(Produto $produto, array $data): Produto
    {
        $data['foto'] = $this->generateImagePath($data);
        return $this->produtoRepository->update($produto, $data);
    }

    public function delete(string $id): void
    {
        $this->produtoRepository->delete($id);
    }
}
