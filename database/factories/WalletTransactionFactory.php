<?php

namespace Database\Factories;

use App\Modules\Wallet\Models\Wallet;
use App\Modules\Wallet\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WalletTransaction::class;

    public function definition(): array
    {
        return [
            'wallet_id' => Wallet::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'currency' => 'USD',
            'type' => $this->faker->randomElement(['credit', 'debit']),
            'description' => $this->faker->sentence(),
            'reference_id' => $this->faker->numberBetween(1, 100),
            'reference_type' => $this->faker->randomElement(['order', 'refund']),
        ];
    }
}
