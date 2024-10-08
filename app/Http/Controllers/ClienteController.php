<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function index(): ClienteResource|JsonResponse
    {
        try {
            $clientes = $this->clienteService->getAll();

            return new ClienteResource($clientes);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function create()
    {

    }

    public function store(ClienteRequest $request): ClienteResource
    {
        $cliente = $this->clienteService->create($request->validated());

        return new ClienteResource($cliente);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
