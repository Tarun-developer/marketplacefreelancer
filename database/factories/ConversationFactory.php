<?php

namespace Database\Factories;

use App\Modules\Chat\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conversation::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['direct', 'group']),
            'title' => $this->faker->sentence(3),
        ];
    }
}
