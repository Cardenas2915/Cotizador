<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->sentence(10),
            'peso'=> $this->faker->sentence(10),
            'volumen' => $this->faker->sentence(10),
            'categoria_id' => $this->faker->randomElement([1,2,5,6])
        ];
    }
}
