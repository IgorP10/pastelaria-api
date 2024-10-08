<?php

namespace App\Repositories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ProdutoRepository
{
    public function getAll(): Collection
    {
        return Produto::all();
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
}
