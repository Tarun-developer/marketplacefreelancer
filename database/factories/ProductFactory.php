<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(3);

        return [
            'user_id' => User::factory(),
            'category_id' => \Database\Factories\CategoryFactory::new(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'currency' => 'USD',
            'license_type' => $this->faker->randomElement(['single', 'multiple']),
            'file_path' => $this->faker->filePath(),
            'preview_images' => [$this->faker->imageUrl()],
            'is_approved' => $this->faker->boolean(),
            'is_featured' => $this->faker->boolean(),
            'download_count' => $this->faker->numberBetween(0, 1000),
            'status' => 'active',
        ];
    }
}
