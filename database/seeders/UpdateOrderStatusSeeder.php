<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateOrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update old status values to new ones
        \App\Models\Order::where('status', 'paid')->update(['status' => 'processing']);
        \App\Models\Order::where('status', 'completed')->update(['status' => 'delivered']);
        \App\Models\Order::where('status', 'canceled')->update(['status' => 'cancelled']); // Fix typo
        
        echo "Updated order statuses successfully!\n";
    }
}
