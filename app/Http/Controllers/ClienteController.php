<?php

namespace App\Http\Controllers;

use App\Services\ClienteService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ClienteRequest;
use App\Http\Resources\ClienteResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClienteController extends Controller
{
    public function __construct(private ClienteService $clienteService)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $clientes = $this->clienteService->getAll();

            return response()->json(ClienteResource::collection($clientes));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function store(ClienteRequest $request): JsonResponse
    {
        $cliente = $this->clienteService->create($request->validated());

        return response()->json(new ClienteResource($cliente), 201);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $cliente = $this->clienteService->getById($id);

            return response()->json(new ClienteResource($cliente));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function update(ClienteRequest $request, string $id): JsonResponse
    {
        try {
            $cliente = $this->clienteService->getById($id);
            $cliente = $this->clienteService->update($cliente, $request->validated());

            return response()->json(new ClienteResource($cliente));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->clienteService->delete($id);

            return response()->json(['message' => 'Cliente deletado com sucesso!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
