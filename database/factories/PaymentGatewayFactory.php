<?php

namespace Database\Factories;

use App\Modules\Payments\Models\PaymentGateway;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentGatewayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentGateway::class;

    public function definition(): array
    {
        $name = $this->faker->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => true,
            'config' => [
                'api_key' => $this->faker->uuid(),
                'secret' => $this->faker->uuid(),
            ],
        ];
    }
}
