<?php

namespace App\Http\Controllers;

use App\Services\ClienteService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ClienteRequest;
use App\Http\Resources\ClienteResource;
use App\Http\Resources\ClienteCollection;
use Symfony\Component\HttpFoundation\Response;

class ClienteController extends Controller
{
    public function __construct(private ClienteService $clienteService)
    {
    }

    public function index(): JsonResponse
    {
        $perPage = request()->input('perPage', 10);
        $page = request()->input('page', 1);
        $clientes = $this->clienteService->getAll($perPage, $page);

        return response()->json(new ClienteCollection($clientes), Response::HTTP_OK);
    }

    public function store(ClienteRequest $request): JsonResponse
    {
        $cliente = $this->clienteService->create($request->validated());

        return response()->json(new ClienteResource($cliente), Response::HTTP_CREATED);
    }

    public function show(string $id): JsonResponse
    {
        $cliente = $this->clienteService->getById($id);

        return response()->json(new ClienteResource($cliente), Response::HTTP_OK);

    }

    public function update(ClienteRequest $request, string $id): JsonResponse
    {
        $cliente = $this->clienteService->update($id, $request->validated());

        return response()->json(new ClienteResource($cliente), Response::HTTP_OK);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->clienteService->delete($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
