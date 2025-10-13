<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Services\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    public function definition(): array
    {
        return [
            'service_id' => \Database\Factories\ServiceFactory::new(),
            'client_id' => User::factory(),
            'freelancer_id' => User::factory(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'currency' => 'USD',
            'delivery_time' => $this->faker->numberBetween(1, 30),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
            'expires_at' => $this->faker->dateTimeBetween('now', '+7 days'),
        ];
    }
}
