<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Users\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bio' => $this->faker->paragraph(),
            'skills' => $this->faker->words(5),
            'location' => $this->faker->city(),
            'portfolio_url' => $this->faker->url(),
            'avatar' => $this->faker->imageUrl(),
            'badge' => $this->faker->word(),
            'is_verified' => $this->faker->boolean(),
            'kyc_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'kyc_documents' => [],
        ];
    }
}
