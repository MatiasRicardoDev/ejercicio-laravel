<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity>
 */
class EntityFactory extends Factory
{
    protected $model = Entity::class;

    public function definition(): array
    {
        return [
            'api' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'link' => $this->faker->url(),
            'category_id' => Category::factory(),
        ];
    }
}
