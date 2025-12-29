<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Farmer;
use App\Models\Delivery;
use App\Models\FarmLocation;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Plasma',
            'email' => 'admin@sbw.com',
            'password' => bcrypt('password'),
        ]);
        // User::factory(10)->create();

        Farmer::factory(50)->create()->each(function ($farmer) {
            // For each farmer, create between 1 to 3 farm locations
            FarmLocation::factory()->create([
                'farmer_id' => $farmer->id,
            ]);

            Delivery::factory(rand(10, 20))->create([
                'farmer_id' => $farmer->id,
            ]);
        });
    }
}
