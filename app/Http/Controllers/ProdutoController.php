<?php

namespace App\Http\Controllers;

use App\Services\ProdutoService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProdutoRequest;
use App\Http\Resources\ProdutoResource;
use App\Http\Resources\ProdutoCollection;
use Symfony\Component\HttpFoundation\Response;

class ProdutoController extends Controller
{
    public function __construct(private ProdutoService $produtoService)
    {
    }

    public function index(): JsonResponse
    {
        $perPage = request()->input('perPage', 10);
        $page = request()->input('page', 1);
        $produtos = $this->produtoService->getAll($perPage, $page);

        return response()->json(new ProdutoCollection($produtos), Response::HTTP_OK);
    }

    public function store(ProdutoRequest $request): JsonResponse
    {
        $produto = $this->produtoService->create($request->validated());

        return response()->json(new ProdutoResource($produto), Response::HTTP_CREATED);
    }

    public function show(string $id): JsonResponse
    {
        $produto = $this->produtoService->getById($id);

        return response()->json(new ProdutoResource($produto), Response::HTTP_OK);
    }

    public function update(ProdutoRequest $request, string $id): JsonResponse
    {
        $produto = $this->produtoService->update($id, $request->validated());

        return response()->json(new ProdutoResource($produto), Response::HTTP_OK);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->produtoService->delete($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
