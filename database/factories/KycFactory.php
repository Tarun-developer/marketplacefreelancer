<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Users\Models\Kyc;
use Illuminate\Database\Eloquent\Factories\Factory;

class KycFactory extends Factory
{
    protected $model = Kyc::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'document_type' => $this->faker->randomElement(['passport', 'id_card', 'driver_license']),
            'document_number' => $this->faker->unique()->numerify('##########'),
            'document_file' => $this->faker->filePath(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'submitted_at' => $this->faker->dateTime(),
            'reviewed_at' => $this->faker->optional()->dateTime(),
            'reviewed_by' => User::factory(),
            'rejection_reason' => $this->faker->optional()->sentence(),
        ];
    }
}
