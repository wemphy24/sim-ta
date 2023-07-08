<?php

namespace Database\Seeders;

use App\Models\DetailUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detailusers = [
            [
                'users_id' => 1,
                'phone' => "0898989898",
                'address' => "Surabaya",
                'photo' => "",
                'department' => "Direktur",
                'roles_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'users_id' => 2,
                'phone' => "0898989898",
                'address' => "Bali",
                'photo' => "",
                'department' => "Marketing",
                'roles_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'users_id' => 3,
                'phone' => "0898989898",
                'address' => "Tangerang",
                'photo' => "",
                'department' => "Quantity Surveyor",
                'roles_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'users_id' => 4,
                'phone' => "0898989898",
                'address' => "Jember",
                'photo' => "",
                'department' => "Produksi",
                'roles_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'users_id' =>5,
                'phone' => "0898989898",
                'address' => "Sidoarjo",
                'photo' => "",
                'department' => "Logistik",
                'roles_id' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        DetailUser::insert($detailusers);
    }
}
