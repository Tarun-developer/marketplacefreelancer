<?php

namespace Database\Factories;

use App\Modules\Chat\Models\Message;
use App\Models\User;
use App\Modules\Chat\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(),
            'user_id' => User::factory(),
            'message' => $this->faker->sentence(),
            'type' => 'text',
            'file_path' => null,
            'is_read' => $this->faker->boolean(),
        ];
    }
}