<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Products::class;

    public function definition()
    {
        return [
            //
            'store_id' => 1,
            'name' => $this->faker->name(),
            'details' => $this->faker->text(10),
            'condition' => 1,
            'brand' => 1,
            'created_at' => $this->faker->dateTime('now')
        ];
    }
}
