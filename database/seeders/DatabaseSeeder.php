<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DetailUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            MeasurementsTableSeeder::class,
            MaterialsTableSeeder::class,
            StatusTableSeeder::class,
            SuppliersTableSeeder::class,
            CustomersTableSeeder::class,
            DetailUsersSeeder::class,
        ]);
    }
}
