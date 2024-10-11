<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PedidoService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Http\Resources\PedidoCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PedidoController extends Controller
{
    public function __construct(private PedidoService $pedidoService)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $perPage = request()->input('perPage', 10);
            $page = request()->input('page', 1);
            $pedidos = $this->pedidoService->getAll($perPage, $page);

            return response()->json(new PedidoCollection($pedidos));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function store(PedidoRequest $request): JsonResponse
    {
        $pedido = $this->pedidoService->create($request->validated());

        return response()->json(new PedidoResource($pedido), 201);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $pedido = $this->pedidoService->getById($id);

            return response()->json(new PedidoResource($pedido));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function update(PedidoRequest $request, string $id): JsonResponse
    {
        try {
            $pedido = $this->pedidoService->getById($id);
            $pedido = $this->pedidoService->update($pedido, $request->validated());

            return response()->json(new PedidoResource($pedido));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->pedidoService->delete($id);

            return response()->json(['message' => 'Pedido deleta com sucesso!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
