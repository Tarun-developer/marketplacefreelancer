<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Jobs\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(5);

        return [
            'client_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraphs(3, true),
            'category' => $this->faker->word(),
            'budget_min' => $this->faker->randomFloat(2, 100, 500),
            'budget_max' => $this->faker->randomFloat(2, 500, 2000),
            'currency' => 'USD',
            'duration' => $this->faker->numberBetween(1, 30),
            'skills_required' => $this->faker->words(5),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'completed', 'cancelled']),
            'expires_at' => $this->faker->dateTimeBetween('now', '+30 days'),
        ];
    }
}
