<?php

namespace App\Repositories;

use App\Models\Produto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProdutoRepository
{
    public function getAll(int $perPage, int $page): LengthAwarePaginator
    {
        return Produto::paginate(
            $perPage,
            ['*'],
            'page',
            $page
        );
    }

    public function getById(string $id): Produto
    {
        return Produto::findOrFail($id);
    }

    public function create(array $data): Produto
    {
        return Produto::create($data);
    }

    public function update(Produto $produto, array $data): Produto
    {
        $produto->update($data);

        return $produto;
    }

    public function delete(Produto $produto): void
    {
        $produto->delete();
    }
}
