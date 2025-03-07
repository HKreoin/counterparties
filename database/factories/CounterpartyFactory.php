<?php

namespace Database\Factories;

use App\Models\Counterparty;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CounterpartyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Counterparty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'inn' => $this->faker->numerify('##########'), // 10-значный ИНН для юр. лиц
            'name' => $this->faker->company(),
            'ogrn' => $this->faker->numerify('#############'), // 13-значный ОГРН для юр. лиц
            'address' => $this->faker->address(),
        ];
    }
}
