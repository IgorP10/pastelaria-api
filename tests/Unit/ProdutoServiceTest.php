<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ProdutoService $produtoService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->produtoService = app(ProdutoService::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_get_all_returns_paginated_produtos(): void
    {
        Produto::factory()->count(15)->create();

        $perPage = 10;
        $page = 1;

        $produtos = $this->produtoService->getAll($perPage, $page);

        $this->assertEquals($perPage, $produtos->perPage());
        $this->assertEquals($page, $produtos->currentPage());
        $this->assertCount($perPage, $produtos->items());
    }

    public function test_create_product(): void
    {
        $file = UploadedFile::fake()->image('foto_teste.jpg');
        $data = [
            'nome' => 'Produto Teste',
            'preco' => 99.99,
            'foto' => $file,
        ];

        $produto = $this->produtoService->create($data);

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'nome' => $produto->nome,
            'preco' => $produto->preco,
            'foto' => $produto->foto,
        ]);

        $this->assertEquals($data['nome'], $produto->nome);
    }

    public function test_get_by_id_returns_produto(): void
    {
        $produto = Produto::factory()->create();

        $result = $this->produtoService->getById($produto->id);
        
        $this->assertInstanceOf(Produto::class, $result);
        $this->assertEquals($produto->id, $result->id);
        $this->assertEquals($produto->nome, $result->nome);
    }

    public function test_update_produto(): void
    {
        $produto = Produto::factory()->create();

        $file = UploadedFile::fake()->image('foto_teste.jpg');
        $data = [
            'nome' => 'Produto Atualizado',
            'preco' => 75.50,
            'foto' => $file,
        ];

        $updatedProduto = $this->produtoService->update($produto->id, $data);

        $this->assertEquals('Produto Atualizado', $updatedProduto->nome);
        $this->assertEquals(75.50, $updatedProduto->preco);
        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'nome' => $updatedProduto->nome,
            'preco' => $updatedProduto->preco,
            'foto' => $updatedProduto->foto,
        ]);
    }

    public function test_delete_produto(): void
    {
        $produto = Produto::factory()->create();

        $this->produtoService->delete($produto->id);

        $this->assertSoftDeleted('produtos', ['id' => $produto->id]);
    }
}
