<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClienteServiceTest extends TestCase
{
    use RefreshDatabase;

    private ClienteService $clienteService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clienteService = app(ClienteService::class);
    }

    public function test_get_all_returns_paginated_clientes(): void
    {
        Cliente::factory()->count(15)->create();

        $perPage = 10;
        $page = 1;

        $clients = $this->clienteService->getAll($perPage, $page);

        $this->assertInstanceOf(LengthAwarePaginator::class, $clients);
        $this->assertEquals($perPage, $clients->perPage());
        $this->assertEquals($page, $clients->currentPage());
        $this->assertCount($perPage, $clients->items());
    }

    public function test_create_cliente(): void
    {
        $clientData = Cliente::factory()->make()->toArray();

        $cliente = $this->clienteService->create($clientData);

        $this->assertInstanceOf(Cliente::class, $cliente);
        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'nome' => $cliente->nome,
            'email' => $cliente->email,
            'telefone' => $cliente->telefone,
            'data_nascimento' => $cliente->data_nascimento,
            'endereco' => $cliente->endereco,
            'bairro' => $cliente->bairro,
            'cep' => $cliente->cep
        ]);
    }

    public function test_get_by_id_returns_cliente(): void
    {
        $client = Cliente::factory()->create();

        $result = $this->clienteService->getById($client->id);

        $this->assertInstanceOf(Cliente::class, $result);
        $this->assertEquals($client->id, $result->id);
    }

    public function test_update_cliente(): void
    {
        $client = Cliente::factory()->create();
        $updatedData = [
            'nome' => 'Novo Nome',
            'email' => $client->email,
            'telefone' => $client->telefone,
            'data_nascimento' => $client->data_nascimento->format('Y-m-d'),
            'endereco' => $client->endereco,
            'bairro' => $client->bairro,
            'cep' => $client->cep
        ];

        $result = $this->clienteService->update($client->id, $updatedData);

        $this->assertEquals('Novo Nome', $result->nome);
    }

    public function test_delete_cliente(): void
    {
        $client = Cliente::factory()->create();

        $this->clienteService->delete($client->id);

        $this->assertSoftDeleted('clientes', ['id' => $client->id]);
    }
}
