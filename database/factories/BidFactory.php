<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Jobs\Models\Bid;
use Illuminate\Database\Eloquent\Factories\Factory;

class BidFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bid::class;

    public function definition(): array
    {
        return [
            'job_id' => \Database\Factories\JobFactory::new(),
            'freelancer_id' => User::factory(),
            'proposal' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'currency' => 'USD',
            'duration' => $this->faker->numberBetween(1, 30),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
