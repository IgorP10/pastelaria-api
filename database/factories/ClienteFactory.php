<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'telefone' => $this->faker->numerify('(##) #####-####'),
            'data_nascimento' => $this->faker->date('Y-m-d'),
            'endereco' => $this->faker->address,
            'complemento' => $this->faker->optional()->sentence,
            'bairro' => $this->faker->word,
            'cep' => $this->faker->postcode,
        ];
    }
}
