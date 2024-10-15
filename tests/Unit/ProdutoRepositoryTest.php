<?php

namespace Tests\Unit;

use App\Models\Produto;
use Tests\TestCase;
use App\Repositories\ProdutoRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProdutoRepository $produtoRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->produtoRepository = new ProdutoRepository();
    }

    public function test_get_all_produtos(): void
    {
        Produto::factory()->count(5)->create();

        $produtos = $this->produtoRepository->getAll(10, 1);

        $this->assertEquals(5, $produtos->total());
    }

    public function test_get_produto_by_id(): void
    {
        $produto = Produto::factory()->create();

        $foundProduto = $this->produtoRepository->getById($produto->id);

        $this->assertEquals($produto->id, $foundProduto->id);
    }

    public function test_create_produto(): void
    {
        $produtoData = Produto::factory()->make()->toArray();

        $produto = $this->produtoRepository->create($produtoData);

        $this->assertDatabaseHas('produtos', ['id' => $produto->id]);
    }

    public function test_update_produto(): void
    {
        $produto = Produto::factory()->create();
        $updatedData = ['nome' => 'Updated Name'];

        $this->produtoRepository->update($produto, $updatedData);

        $this->assertDatabaseHas('produtos', ['id' => $produto->id, 'nome' => 'Updated Name']);
    }

    public function test_delete_produto(): void
    {
        $produto = Produto::factory()->create();

        $this->produtoRepository->delete($produto);

        $this->assertSoftDeleted('produtos', ['id' => $produto->id]);
    }
}
