<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Classic Cheeseburger',
                'description' => 'Juicy beef patty with melted cheese, lettuce, tomato, and our special sauce',
                'price' => 12.99,
                'category' => 'burger',
                'image_url' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=400&fit=crop',
                'available' => true,
            ],
            [
                'name' => 'Crispy Chicken Wings',
                'description' => 'Golden crispy wings served with your choice of sauce',
                'price' => 8.99,
                'category' => 'chicken',
                'image_url' => 'https://images.unsplash.com/photo-1527477396000-e27163b481c2?w=400&h=400&fit=crop',
                'available' => true,
            ],
            [
                'name' => 'French Fries',
                'description' => 'Crispy golden fries seasoned to perfection',
                'price' => 4.99,
                'category' => 'sides',
                'image_url' => 'https://images.unsplash.com/photo-1541592106381-b31e89e90224?w=400&h=400&fit=crop',
                'available' => true,
            ],
            [
                'name' => 'Coca Cola',
                'description' => 'Refreshing cold Coca Cola',
                'price' => 2.99,
                'category' => 'drinks',
                'image_url' => 'https://images.unsplash.com/photo-1561758033-d89a9ad46330?w=400&h=400&fit=crop',
                'available' => true,
            ],
            [
                'name' => 'BBQ Bacon Burger',
                'description' => 'Double beef patty with bacon, BBQ sauce, and onion rings',
                'price' => 15.99,
                'category' => 'burger',
                'image_url' => '/images/placeholder-product.svg',
                'available' => false,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
        
        echo "Test products created successfully!\n";
    }
}
