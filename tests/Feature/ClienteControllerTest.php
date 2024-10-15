<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cliente;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_clients(): void
    {
        Cliente::factory()->count(20)->create();

        $response = $this->getJson(route('clientes.index', ['perPage' => 10, 'page' => 1]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'nome',
                            'email',
                            'telefone',
                            'data_nascimento',
                            'endereco',
                            'complemento',
                            'bairro',
                            'cep',
                            'pedidos',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                    'pagination' => [
                        'current_page',
                        'last_page',
                        'per_page',
                        'total',
                        'links' => [
                            'next',
                            'prev',
                        ]
                    ]
                ]
            );
    }

    public function test_store_creates_a_new_client(): void
    {
        $clientData = Cliente::factory()->make()->toArray();

        $response = $this->postJson(route('clientes.store'), $clientData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'id',
                    'nome',
                    'email',
                    'telefone',
                    'endereco'
                ]
            );
    }

    public function test_show_returns_a_single_client(): void
    {
        $client = Cliente::factory()->create();

        $response = $this->getJson(route('clientes.show', $client->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                [
                    'id' => $client->id,
                    'nome' => $client->nome,
                    'email' => $client->email,
                    'telefone' => $client->telefone,
                    'data_nascimento' => $client->data_nascimento->format('Y-m-d'),
                    'endereco' => $client->endereco,
                    'complemento' => $client->complemento,
                    'bairro' => $client->bairro,
                    'cep' => $client->cep,
                ]
            );
    }

    public function test_update_modifies_a_client(): void
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

        $response = $this->putJson(route('clientes.update', $client->id), $updatedData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                [
                    'id' => $client->id,
                    'nome' => 'Novo Nome',
                    'email' => $client->email,
                    'telefone' => $client->telefone,
                    'data_nascimento' => $client->data_nascimento->format('Y-m-d'),
                    'endereco' => $client->endereco,
                    'complemento' => $client->complemento,
                    'bairro' => $client->bairro,
                    'cep' => $client->cep
                ]
            );
    }

    public function test_destroy_deletes_a_client(): void
    {
        $client = Cliente::factory()->create();
        $this->assertDatabaseHas('clientes', ['id' => $client->id]);

        $response = $this->deleteJson(route('clientes.destroy', $client->id));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted('clientes', ['id' => $client->id]);
    }
}
