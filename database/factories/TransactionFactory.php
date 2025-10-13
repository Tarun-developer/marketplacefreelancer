<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Orders\Models\Order;
use App\Modules\Payments\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_id' => Order::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'currency' => 'USD',
            'gateway' => $this->faker->randomElement(['stripe', 'paypal', 'razorpay']),
            'gateway_transaction_id' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed', 'refunded']),
            'type' => $this->faker->randomElement(['payment', 'refund']),
            'description' => $this->faker->sentence(),
            'metadata' => [],
        ];
    }
}
