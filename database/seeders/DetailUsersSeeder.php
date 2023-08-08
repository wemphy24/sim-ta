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
                'department' => "Purchasing",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'users_id' => 2,
                'phone' => "0898989898",
                'address' => "Badung",
                'photo' => "",
                'department' => "Marketing",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'users_id' => 3,
                'phone' => "0898989898",
                'address' => "Munggu",
                'photo' => "",
                'department' => "Quantity Surveyor",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'users_id' => 4,
                'phone' => "0898989898",
                'address' => "Munggu",
                'photo' => "",
                'department' => "Produksi",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'users_id' =>5,
                'phone' => "0898989898",
                'address' => "Munggu",
                'photo' => "",
                'department' => "Logistik",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'users_id' =>6,
                'phone' => "0898989898",
                'address' => "Badung",
                'photo' => "",
                'department' => "Direktur",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        DetailUser::insert($detailusers);
    }
}
