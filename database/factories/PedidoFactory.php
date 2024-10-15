<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cliente = Cliente::factory()->create();
        $Produto = Produto::factory()->create();
        return [
            'cliente_id' => $cliente->id,
            'produtos' => [
                [
                    'id' => $Produto->id,
                    'quantidade' => $this->faker->numberBetween(1, 5),
                ],
            ],
            'total' => round($this->faker->randomFloat(2, 10, 100), 2),
        ];
    }
}
