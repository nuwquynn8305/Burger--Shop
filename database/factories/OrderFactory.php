<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentMethods = ['vnpay', 'cod', 'cash_on_delivery'];
        $statuses = ['pending', 'paid', 'processing', 'completed', 'cancelled', 'canceled'];
        
        return [
            'user_id' => \App\Models\User::factory(),
            'total_price' => $this->faker->randomFloat(2, 15, 200),
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'status' => $this->faker->randomElement($statuses),
        ];
    }
}
