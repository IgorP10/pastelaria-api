<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Services\ProdutoService;
use Illuminate\Http\Request;
use App\Http\Resources\ProdutoResource;

class ProdutoController extends Controller
{
    public function __construct(private ProdutoService $produtoService)
    {
    }

    public function index(): ProdutoResource
    {
        $produtos = $this->produtoService->getAll();

        return new ProdutoResource($produtos);
    }

    public function create()
    {
    }

    public function store(ProdutoRequest $request): ProdutoResource
    {
        $produto = $this->produtoService->create($request->validated());

        return new ProdutoResource($produto);
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }


    public function update(Request $request, string $id)
    {
    }


    public function destroy(string $id)
    {
    }
}
