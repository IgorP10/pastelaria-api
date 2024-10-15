<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pedido;
use App\Repositories\PedidoRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    private PedidoRepository $pedidoRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pedidoRepository = new PedidoRepository();
    }

    public function test_get_all_pedidos(): void
    {
        Pedido::factory()->count(5)->create();
        $pedidos = $this->pedidoRepository->getAll(10, 1);

        $this->assertEquals(5, $pedidos->total());
    }

    public function test_get_pedido_by_id(): void
    {
        $pedido = Pedido::factory()->create();
        $foundPedido = $this->pedidoRepository->getById($pedido->id);

        $this->assertEquals($pedido->id, $foundPedido->id);
    }

    public function test_create_pedido(): void
    {
        $pedidoData = Pedido::factory()->make()->toArray();
        $pedido = $this->pedidoRepository->create($pedidoData);

        $this->assertDatabaseHas('pedidos', ['id' => $pedido->id]);
    }

    public function test_update_pedido(): void
    {
        $pedido = Pedido::factory()->create();
        $updatedData = ['total' => 100.00];
        $this->pedidoRepository->update($pedido, $updatedData);

        $this->assertDatabaseHas('pedidos', ['id' => $pedido->id, 'total' => 100.00]);
    }

    public function test_delete_pedido(): void
    {
        $pedido = Pedido::factory()->create();
        $this->pedidoRepository->delete($pedido);

        $this->assertSoftDeleted('pedidos', ['id' => $pedido->id]);
    }
}
