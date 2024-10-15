<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClienteRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ClienteRepository $clienteRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clienteRepository = new ClienteRepository();
    }

    public function test_get_all_clientes(): void
    {
        Cliente::factory()->count(5)->create();

        $clientes = $this->clienteRepository->getAll(10, 1);

        $this->assertEquals(5, $clientes->total());
    }

    public function test_get_cliente_by_id(): void
    {
        $client = Cliente::factory()->create();

        $foundClient = $this->clienteRepository->getById($client->id);

        $this->assertEquals($client->id, $foundClient->id);
    }

    public function test_create_cliente(): void
    {
        $clientData = Cliente::factory()->make()->toArray();

        $client = $this->clienteRepository->create($clientData);

        $this->assertDatabaseHas('clientes', ['id' => $client->id]);
    }

    public function test_update_cliente(): void
    {
        $client = Cliente::factory()->create();
        $updatedData = ['nome' => 'Updated Name'];

        $this->clienteRepository->update($client, $updatedData);

        $this->assertDatabaseHas('clientes', ['id' => $client->id, 'nome' => 'Updated Name']);
    }

    public function test_delete_cliente(): void
    {
        $client = Cliente::factory()->create();

        $this->clienteRepository->delete($client);

        $this->assertSoftDeleted('clientes', ['id' => $client->id]);
    }
}
