<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'details' => $this->faker->text(20),
            'condition' => 1,
            'brand' => 1,
            'created_at' => $this->faker->dateTime('now')
        ];
    }
}
