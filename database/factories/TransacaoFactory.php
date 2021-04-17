<?php

namespace Database\Factories;

use App\Models\Transacao;
use App\Models\Conta;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransacaoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transacao::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('pt_BR');
        return [
            'conta_id' => Conta::all()->random()->id,
            'valor' => $faker->randomFloat(2, 1, 100),
            'tipo' => 'deposito'
        ];
    }
}
