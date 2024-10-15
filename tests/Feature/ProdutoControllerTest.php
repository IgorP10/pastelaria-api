<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Produto;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_produtos(): void
    {
        Produto::factory()->count(20)->create();

        $response = $this->getJson(route('produtos.index', ['perPage' => 10, 'page' => 1]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'nome',
                            'preco',
                            'foto',
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

    public function test_store_creates_a_new_produto(): void
    {
        $produtoData = [
            'nome' => 'Produto Teste',
            'preco' => 99.99,
            'foto' => UploadedFile::fake()->image('produto.jpg')
        ];

        $response = $this->postJson(route('produtos.store'), $produtoData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'id',
                    'nome',
                    'preco',
                    'foto',
                    'created_at',
                    'updated_at'
                ]
            );

        $this->assertDatabaseHas('produtos', [
            'nome' => 'Produto Teste',
            'preco' => 99.99
        ]);
    }

    public function test_show_returns_a_single_produto(): void
    {
        $produto = Produto::factory()->create();

        $response = $this->getJson(route('produtos.show', $produto->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'id' => $produto->id,
                'nome' => $produto->nome,
                'preco' => $produto->preco,
                'foto' => $produto->foto,
            ]);
    }

    public function test_update_modifies_a_produto(): void
    {
        $produto = Produto::factory()->create();
        $updatedData = [
            'nome' => 'Produto Atualizado',
            'preco' => 129.99,
            'foto' => UploadedFile::fake()->image('novo_produto.jpg')
        ];

        $response = $this->putJson(route('produtos.update', $produto->id), $updatedData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'id' => $produto->id,
                'nome' => 'Produto Atualizado',
                'preco' => 129.99,
            ]);

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'nome' => 'Produto Atualizado',
            'preco' => 129.99
        ]);
    }

    public function test_destroy_deletes_a_produto(): void
    {
        $produto = Produto::factory()->create();
        $this->assertDatabaseHas('produtos', ['id' => $produto->id]);

        $response = $this->deleteJson(route('produtos.destroy', $produto->id));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted('produtos', ['id' => $produto->id]);
    }
}
