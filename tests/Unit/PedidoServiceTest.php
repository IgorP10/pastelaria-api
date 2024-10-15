<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;
use App\Services\PedidoService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoServiceTest extends TestCase
{
    use RefreshDatabase;

    private PedidoService $pedidoService;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->pedidoService = app(PedidoService::class);
    }

    public function test_get_all_returns_paginated_pedidos(): void
    {
        Pedido::factory()->count(15)->create();
        
        $perPage = 10;
        $page = 1;

        $pedidos = $this->pedidoService->getAll($perPage, $page);

        $this->assertInstanceOf(LengthAwarePaginator::class, $pedidos);
        $this->assertEquals($perPage, $pedidos->perPage());
        $this->assertEquals($page, $pedidos->currentPage());
        $this->assertCount($perPage, $pedidos->items());
    }

    public function test_create_pedido(): void
    {
        $pedidoData = Pedido::factory()->make()->toArray();

        $pedido = $this->pedidoService->create($pedidoData);

        $this->assertInstanceOf(Pedido::class, $pedido);
        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'total' => $pedido->total,
            'cliente_id' => $pedido->cliente_id
        ]);
    }

    public function test_get_by_id_returns_pedido(): void
    {
        $pedido = Pedido::factory()->create();

        $foundPedido = $this->pedidoService->getById($pedido->id);

        $this->assertEquals($pedido->id, $foundPedido->id);
    }

    public function test_update_pedido(): void
    {
        $pedido = Pedido::factory()->create();
        $produtos = Produto::factory()->count(5)->create();
        $updatedData = [
            'cliente_id' => (Cliente::factory()->create())->id,
            'produtos' => [
                ['id' => $produtos[0]->id, 'quantidade' => 2],
                ['id' => $produtos[1]->id, 'quantidade' => 3],
                ['id' => $produtos[2]->id, 'quantidade' => 4],
                ['id' => $produtos[3]->id, 'quantidade' => 5],
                ['id' => $produtos[4]->id, 'quantidade' => 6]
            ]
        ];

        $total = 0;
        foreach ($updatedData['produtos'] as $produto) {
            $total += round($produto['quantidade'] * Produto::find($produto['id'])->preco, 2);
        }

        $result = $this->pedidoService->update($pedido->id, $updatedData);

        $this->assertEquals($total, $result->total);
    }

    public function test_delete_pedido(): void
    {
        $pedido = Pedido::factory()->create();

        $this->pedidoService->delete($pedido->id);

        $this->assertSoftDeleted('pedidos', ['id' => $pedido->id]);
    }
}
