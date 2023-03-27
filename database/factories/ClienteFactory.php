<?php

namespace Database\Factories;

use App\Models\Cliente;
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

    protected $model = Cliente::class;


    public function definition()
    {
        return [

        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
        'rg' => $this->faker->unique->numberBetween(1000000,10000000),
        'cpf' => $this->faker->unique->numberBetween(1000000,10000000),
        'email' => fake()->unique()->safeEmail(),
        'endereco' => $this->faker->unique()->address(),

        ];
    }
}
