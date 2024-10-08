<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Http\Resources\PedidoResource;
use Illuminate\Http\Request;
use App\Services\PedidoService;

class PedidoController extends Controller
{
    public function __construct(private PedidoService $pedidoService)
    {
    }

    public function index(): PedidoResource
    {
        $pedidos = $this->pedidoService->getAll();

        return new PedidoResource($pedidos);
    }

    public function create(PedidoRequest $request): PedidoResource
    {
        $pedido = $this->pedidoService->create($request->validated());

        return new PedidoResource($pedido);
    }

    public function store(Request $request)
    {
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
        //
    }
}
