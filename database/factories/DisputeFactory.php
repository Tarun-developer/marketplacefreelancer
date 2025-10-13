<?php

namespace Database\Factories;

use App\Modules\Disputes\Models\Dispute;
use App\Models\User;
use App\Modules\Orders\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisputeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dispute::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'raised_by' => User::factory(),
            'reason' => $this->faker->randomElement(['delivery', 'quality', 'payment']),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'resolved', 'closed']),
            'resolved_by' => User::factory(),
            'resolved_at' => $this->faker->optional()->dateTime(),
            'resolution' => $this->faker->optional()->paragraph(),
        ];
    }
}