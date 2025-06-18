<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class UpdateOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing orders with new columns
        $orders = Order::all();
        foreach ($orders as $order) {
            $order->update([
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
                'notes' => fake()->optional()->sentence(),
                'transaction_id' => $order->payment_method === 'vnpay' ? 'TXN' . fake()->randomNumber(8) : null,
            ]);
        }

        // Create additional sample orders
        $users = User::where('role', '!=', 'admin')->get();
        $products = Product::where('available', true)->get();

        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            $orderProducts = $products->random(rand(1, 4));
            $totalPrice = $orderProducts->sum('price');

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'payment_method' => fake()->randomElement(['vnpay', 'cod']),
                'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
                'notes' => fake()->optional(0.3)->sentence(),
                'transaction_id' => fake()->boolean(60) ? 'TXN' . fake()->randomNumber(8) : null,
                'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            ]);

            // Create order items
            foreach ($orderProducts as $product) {
                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price,
                ]);
            }
        }

        $this->command->info('Orders updated and additional sample orders created!');
    }
}
