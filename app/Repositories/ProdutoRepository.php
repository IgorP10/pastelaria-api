<?php

namespace App\Repositories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProdutoRepository
{
    public function getAll(int $perPage, int $page): LengthAwarePaginator
    {
        $produtos = Produto::paginate(
            $perPage,
            ['*'],
            'page',
            $page
        );

        if ($produtos->isEmpty()) {
            throw new ModelNotFoundException('Nenhum produto encontrado');
        }

        return $produtos;
    }

    public function getById(string $id): Produto
    {
        $produto = Produto::find($id);

        if (!$produto) {
            throw new ModelNotFoundException('Produto não encontrado');
        }

        return $produto;
    }

    public function create(array $data): Model
    {
        return Produto::create($data);
    }

    public function update(Produto $produto, array $data): Produto
    {
        $produto->update($data);

        return $produto;
    }

    public function delete(string $id): void
    {
        $produto = Produto::find($id);

        if (!$produto) {
            throw new ModelNotFoundException('Produto não encontrado');
        }

        $produto->delete();
    }
}
