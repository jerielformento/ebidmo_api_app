<?php

namespace Database\Factories;

use App\Models\Customers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CustomersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Customers::class;

    public function definition()
    {
        return [
            'username' => $this->faker->userName(),
            'password' => Hash::make($this->faker->password(10)),
            'role' => 1,
            'auth_type' => 1,
            'is_verified' => 1,
            'remember_token' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'registered_at' => $this->faker->dateTime('now')
        ];
    }
}
