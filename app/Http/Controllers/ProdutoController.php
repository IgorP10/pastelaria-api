<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProdutoCollection;
use App\Services\ProdutoService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProdutoRequest;
use App\Http\Resources\ProdutoResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProdutoController extends Controller
{
    public function __construct(private ProdutoService $produtoService)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $perPage = request()->input('perPage', 10);
            $page = request()->input('page', 1);
            $produtos = $this->produtoService->getAll($perPage, $page);

            return response()->json(new ProdutoCollection($produtos));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }


    public function store(ProdutoRequest $request): ProdutoResource
    {
        $produto = $this->produtoService->create($request->validated());

        return new ProdutoResource($produto);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $produto = $this->produtoService->getById($id);

            return response()->json(new ProdutoResource($produto));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function update(ProdutoRequest $request, string $id): JsonResponse
    {
        try {
            $produto = $this->produtoService->getById($id);
            $produto = $this->produtoService->update($produto, $request->validated());

            return response()->json(new ProdutoResource($produto));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }


    public function destroy(string $id): JsonResponse
    {
        try {
            $this->produtoService->delete($id);

            return response()->json(['message' => 'Produto deletado com sucesso!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
