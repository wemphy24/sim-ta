<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Wemphy Stephian',
                'email' => 'wemphysp@gmail.com',
                'password' => Hash::make('okebitch24'),
                'role' => 'Purchasing',
                'remember_token' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Kartika',
                'email' => 'kartikaa99_@gmail.com',
                'password' => Hash::make('okebitch24'),
                'role' => 'Marketing',
                'remember_token' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Livy',
                'email' => 'livy@gmail.com',
                'password' => Hash::make('okebitch24'),
                'role' => 'QS',
                'remember_token' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Jacelline',
                'email' => 'jacelline@gmail.com',
                'password' => Hash::make('okebitch24'),
                'role' => 'Produksi',
                'remember_token' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Wayan',
                'email' => 'wayan_96@gmail.com',
                'password' => Hash::make('okebitch24'),
                'role' => 'Logistik',
                'remember_token' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Nailul',
                'email' => 'nailul17@gmail.com',
                'password' => Hash::make('haha123'),
                'role' => 'Direktur',
                'remember_token' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        User::insert($users);
    }
}
