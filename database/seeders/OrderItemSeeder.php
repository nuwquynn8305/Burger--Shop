<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $products = Product::all();

        foreach ($orders as $order) {
            // Add 1 to 5 items to each order
            $itemCount = rand(1, 5);
            
            // Track the total price for updating the order
            $totalPrice = 0;
            
            for ($i = 0; $i < $itemCount; $i++) {
                // Get a random product
                $product = $products->random();
                $quantity = rand(1, 3);
                $price = $product->price;
                
                // Create the order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
                
                // Add to total price
                $totalPrice += ($price * $quantity);
            }
            
            // Update the order with the calculated total price
            $order->update([
                'total_price' => $totalPrice,
            ]);
        }
    }
}
