<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            // Create between 0 and 3 orders for each user
            $orderCount = rand(0, 3);
            
            for ($i = 0; $i < $orderCount; $i++) {
                Order::factory()->create([
                    'user_id' => $user->id,
                ]);
            }
        }
        
        // Create some additional random orders
        Order::factory()->count(5)->create();
    }
}
