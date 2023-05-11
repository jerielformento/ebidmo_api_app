<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->word().' '.$this->faker->word();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'details' => $this->faker->text(20),
            'condition' => 1,
            'brand' => 1,
            'quantity' => 1,
            'created_at' => $this->faker->dateTime('now')
        ];
    }
}
