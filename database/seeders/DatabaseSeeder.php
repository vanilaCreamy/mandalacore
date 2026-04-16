<?php

namespace Database\Seeders;

// use App\Models\User;
use Database\Seeders\MaterialCategorySeeder;
use Database\Seeders\MaterialSeeder;
use Database\Seeders\PortionBaseSeeder;
use Database\Seeders\PosyanduSeeder;
use Database\Seeders\SchoolSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SchoolSeeder::class,
            PosyanduSeeder::class,
            MaterialCategorySeeder::class,
            MaterialSeeder::class,
            PortionBaseSeeder::class
        ]);
    }
}
