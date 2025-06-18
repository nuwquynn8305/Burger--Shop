<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create predefined burger products
        Product::create([
            'name' => 'Classic Burger',
            'description' => 'Our signature beef patty with fresh lettuce, tomato, onion, and special sauce.',
            'price' => 9.99,
            'category' => 'burger',
            'image_url' => 'images/products/classic-burger.jpg',
        ]);
        
        Product::create([
            'name' => 'Double Cheese Burger',
            'description' => 'Two juicy beef patties with melted cheese, pickles, and our secret sauce.',
            'price' => 12.99,
            'category' => 'burger',
            'image_url' => 'images/products/double-cheese-burger.jpg',
        ]);
        
        // Create predefined chicken products
        Product::create([
            'name' => 'Crispy Chicken Sandwich',
            'description' => 'Crispy fried chicken breast with lettuce, mayo, and pickles on a toasted bun.',
            'price' => 8.99,
            'category' => 'chicken',
            'image_url' => 'images/products/crispy-chicken-sandwich.jpg',
        ]);
        
        Product::create([
            'name' => 'Chicken Wings (8pcs)',
            'description' => 'Juicy chicken wings tossed in your choice of BBQ, Buffalo, or Honey Garlic sauce.',
            'price' => 10.99,
            'category' => 'chicken',
            'image_url' => 'images/products/chicken-wings.jpg',
        ]);
        
        // Create predefined sides
        Product::create([
            'name' => 'French Fries',
            'description' => 'Crispy golden fries served with ketchup.',
            'price' => 3.99,
            'category' => 'sides',
            'image_url' => 'images/products/french-fries.jpg',
        ]);
        
        Product::create([
            'name' => 'Onion Rings',
            'description' => 'Crispy breaded onion rings served with dipping sauce.',
            'price' => 4.99,
            'category' => 'sides',
            'image_url' => 'images/products/onion-rings.jpg',
        ]);
        
        // Create predefined drinks
        Product::create([
            'name' => 'Soft Drink',
            'description' => 'Your choice of Coca-Cola, Sprite, or Fanta.',
            'price' => 2.49,
            'category' => 'drinks',
            'image_url' => 'images/products/soft-drink.jpg',
        ]);
        
        Product::create([
            'name' => 'Milkshake',
            'description' => 'Creamy milkshake in vanilla, chocolate, or strawberry flavor.',
            'price' => 4.99,
            'category' => 'drinks',
            'image_url' => 'images/products/milkshake.jpg',
        ]);
        
        // Create predefined desserts
        Product::create([
            'name' => 'Ice Cream Sundae',
            'description' => 'Vanilla ice cream topped with chocolate sauce and whipped cream.',
            'price' => 3.99,
            'category' => 'desserts',
            'image_url' => 'images/products/ice-cream-sundae.jpg',
        ]);
        
        Product::create([
            'name' => 'Apple Pie',
            'description' => 'Warm apple pie with a flaky crust.',
            'price' => 4.49,
            'category' => 'desserts',
            'image_url' => 'images/products/apple-pie.jpg',
        ]);
        
        // Vietnamese products to test enhanced search functionality
        Product::create([
            'name' => 'Bánh Mỳ Gà Nướng',
            'description' => 'Vietnamese grilled chicken sandwich with fresh herbs and vegetables.',
            'price' => 7.99,
            'category' => 'burger',
            'image_url' => 'images/products/banh-mi-ga-nuong.jpg',
        ]);
        
        Product::create([
            'name' => 'Gà Rán Giòn',
            'description' => 'Crispy fried chicken pieces with Vietnamese spices.',
            'price' => 11.99,
            'category' => 'chicken',
            'image_url' => 'images/products/ga-ran-gion.jpg',
        ]);
        
        Product::create([
            'name' => 'Khoai Tây Chiên',
            'description' => 'Crispy French fries with Vietnamese chili salt.',
            'price' => 4.49,
            'category' => 'sides',
            'image_url' => 'images/products/khoai-tay-chien.jpg',
        ]);
        
        Product::create([
            'name' => 'Nước Chanh Dây',
            'description' => 'Fresh passion fruit juice with ice.',
            'price' => 3.49,
            'category' => 'drinks',
            'image_url' => 'images/products/nuoc-chanh-day.jpg',
        ]);
        
        Product::create([
            'name' => 'Bánh Flan',
            'description' => 'Vietnamese caramel custard dessert.',
            'price' => 3.99,
            'category' => 'desserts',
            'image_url' => 'images/products/banh-flan.jpg',
        ]);

        // Create additional random products
        Product::factory()->count(15)->create();
    }
}
