<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produto::factory()->createMany([
            [
                'nome' => 'Produto de Calabresa',
                'preco' => 10.5,
                'foto' => 'produtos/pastel-de-calabresa.png',
            ],
            [
                'nome' => 'Pastel de Carne',
                'preco' => 10.25,
                'foto' => 'produtos/pastel-de-carne.jpg',
            ]
        ]);
    }
}
