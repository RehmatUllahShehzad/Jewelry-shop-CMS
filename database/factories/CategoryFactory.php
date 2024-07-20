<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'is_popular' => true,
            'is_published' => true,

        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Category $category) {
            $category
                ->addMedia(
                    storage_path('data/sample.jpg')
                )
                ->preservingOriginal()
                ->withCustomProperties(['primary' => true, 'position' => 1])
                ->toMediaCollection(get_class($category));
        });
    }
}
