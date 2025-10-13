<?php

namespace Database\Factories;

use App\Modules\Support\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportTicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupportTicket::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category' => $this->faker->randomElement(['billing', 'technical', 'order', 'general']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'resolved', 'closed']),
            'assigned_to' => User::factory(),
            'closed_at' => $this->faker->optional()->dateTime(),
        ];
    }
}