<?php

namespace Database\Factories;

use App\Modules\Products\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'icon' => $this->faker->word(),
            'parent_id' => null,
            'is_active' => true,
            'commission_rate' => $this->faker->randomFloat(2, 5, 20),
        ];
    }
}
