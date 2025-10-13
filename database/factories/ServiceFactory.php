<?php

namespace Database\Factories;

use App\Modules\Services\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(4);
        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraphs(3, true),
            'category' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'currency' => 'USD',
            'delivery_time' => $this->faker->numberBetween(1, 30),
            'revisions' => $this->faker->numberBetween(1, 5),
            'images' => [$this->faker->imageUrl()],
            'is_active' => true,
            'status' => 'active',
        ];
    }
}