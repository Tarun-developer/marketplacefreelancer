<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Orders\Models\Order;
use App\Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'reviewer_id' => User::factory(),
            'reviewee_id' => User::factory(),
            'order_id' => Order::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(['product', 'service', 'job']),
        ];
    }
}
