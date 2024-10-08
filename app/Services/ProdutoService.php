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

    public function create(array $data): Model
    {
        return $this->produtoRepository->create($data);
    }

    public function update(Produto $produto, array $data): Produto
    {
        return $this->produtoRepository->update($produto, $data);
    }
}
