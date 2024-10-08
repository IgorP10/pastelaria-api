<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PedidoService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PedidoRequest;
use App\Http\Resources\PedidoResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PedidoController extends Controller
{
    public function __construct(private PedidoService $pedidoService)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $pedidos = $this->pedidoService->getAll();

            return response()->json(PedidoResource::collection($pedidos));
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

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
