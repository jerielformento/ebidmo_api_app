<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomersProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email(),
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'middle_name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber()
        ];
    }
}
