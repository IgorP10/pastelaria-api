<?php

namespace App\Http\Controllers;

use App\Services\PedidoService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Http\Resources\PedidoCollection;
use Symfony\Component\HttpFoundation\Response;

class PedidoController extends Controller
{
    public function __construct(private PedidoService $pedidoService)
    {
    }

    public function index(): JsonResponse
    {
        $perPage = request()->input('perPage', 10);
        $page = request()->input('page', 1);
        $pedidos = $this->pedidoService->getAll($perPage, $page);

        return response()->json(new PedidoCollection($pedidos), Response::HTTP_OK);
    }

    public function store(PedidoRequest $request): JsonResponse
    {
        $pedido = $this->pedidoService->create($request->validated());

        return response()->json(new PedidoResource($pedido), Response::HTTP_CREATED);
    }

    public function show(string $id): JsonResponse
    {
        $pedido = $this->pedidoService->getById($id);

        return response()->json(new PedidoResource($pedido), Response::HTTP_OK);
    }

    public function update(PedidoRequest $request, string $id): JsonResponse
    {
        $pedido = $this->pedidoService->update($id, $request->validated());

        return response()->json(new PedidoResource($pedido), Response::HTTP_OK);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->pedidoService->delete($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
