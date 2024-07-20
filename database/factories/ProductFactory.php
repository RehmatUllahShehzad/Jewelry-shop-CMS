<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => ($slug = $this->faker->unique()->text(10)),
            'description' => $this->faker->text(25),
            'specifications' => $this->faker->text(25),
            'materials' => $this->faker->text(25),
            'staff_id' => 1,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product
                ->addMedia(
                    storage_path('data/sample.jpg')
                )
                ->preservingOriginal()
                ->withCustomProperties(['primary' => true, 'position' => 1])
                ->toMediaCollection(get_class($product));
        });
    }
}
