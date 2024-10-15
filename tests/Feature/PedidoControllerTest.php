<?php

namespace Tests\Feature;

use App\Models\Produto;
use Tests\TestCase;
use App\Models\Pedido;
use App\Models\Cliente;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_pedidos(): void
    {
        Pedido::factory()->count(20)->create();

        $response = $this->getJson(route('pedidos.index', ['perPage' => 10, 'page' => 1]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'cliente' => [
                                'id',
                                'nome',
                                'email',
                                'telefone',
                                'endereco',
                                'complemento',
                                'bairro',
                                'cep'
                            ],
                            'produtos' => [
                                '*' => [
                                    'id',
                                    'quantidade'
                                ]
                            ],
                            'total',
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

    public function test_store_creates_a_new_pedido(): void
    {
        $cliente = Cliente::factory()->create();
        $produto = Produto::factory()->count(5)->create();

        $pedidoData = [
            'cliente_id' => $cliente->id,
            'produtos' => [
                ['id' => $produto[0]->id, 'quantidade' => 2],
                ['id' => $produto[1]->id, 'quantidade' => 3],
            ]
        ];

        $response = $this->postJson(route('pedidos.store'), $pedidoData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'id',
                    'cliente' => [
                        'id',
                        'nome',
                        'email',
                        'telefone',
                        'endereco',
                        'complemento',
                        'bairro',
                        'cep'
                    ],
                    'produtos',
                    'total',
                    'created_at',
                    'updated_at'
                ]
            );
    }

    public function test_show_returns_a_single_pedido(): void
    {
        $pedido = Pedido::factory()->create();

        $response = $this->getJson(route('pedidos.show', $pedido->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                [
                    'id' => $pedido->id,
                    'cliente' => [
                        'id' => $pedido->cliente->id,
                        'nome' => $pedido->cliente->nome,
                        'email' => $pedido->cliente->email,
                        'telefone' => $pedido->cliente->telefone,
                        'endereco' => $pedido->cliente->endereco,
                        'complemento' => $pedido->cliente->complemento,
                        'bairro' => $pedido->cliente->bairro,
                        'cep' => $pedido->cliente->cep,
                    ],
                    'produtos' => [
                        ['id' => $pedido->produtos[0]['id'], 'quantidade' => $pedido->produtos[0]['quantidade']],
                    ],
                    'total' => $pedido->total,
                ]
            );
    }

    public function test_update_modifies_a_pedido(): void
    {
        $pedido = Pedido::factory()->create();
        $produto = Produto::factory()->count(5)->create();
        $updatedData = [
            'cliente_id' => $pedido->cliente->id,
            'produtos' => [
                ['id' => $produto[3]->id, 'quantidade' => 1],
                ['id' => $produto[4]->id, 'quantidade' => 1],
            ],
        ];
        $total = $produto[3]->preco + $produto[4]->preco;
        
        $response = $this->putJson(route('pedidos.update', $pedido->id), $updatedData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                [
                    'id' => $pedido->id,
                    'cliente' => [
                        'id' => $pedido->cliente->id,
                        'nome' => $pedido->cliente->nome,
                        'email' => $pedido->cliente->email,
                        'telefone' => $pedido->cliente->telefone,
                        'endereco' => $pedido->cliente->endereco,
                        'complemento' => $pedido->cliente->complemento,
                        'bairro' => $pedido->cliente->bairro,
                        'cep' => $pedido->cliente->cep,
                    ],
                    'produtos' => [
                        ['id' => $produto[3]->id, 'quantidade' => 1],
                        ['id' => $produto[4]->id, 'quantidade' => 1],
                    ],
                    'total' => $total,
                ]
            );
    }

    public function test_destroy_deletes_a_pedido(): void
    {
        $pedido = Pedido::factory()->create();
        $this->assertDatabaseHas('pedidos', ['id' => $pedido->id]);

        $response = $this->deleteJson(route('pedidos.destroy', $pedido->id));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted('pedidos', ['id' => $pedido->id]);
    }
}
