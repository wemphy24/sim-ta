<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            [
                'name' => 'PT. Schneider Indonesia',
                'email' => 'schneider@gmail.com',
                'phone' => '08198726534',
                'address' => 'Surabaya',
                'officer' => 'Zenix',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'PT. Siemens Indonesia',
                'email' => 'siemens@gmail.com',
                'phone' => '08987266514',
                'address' => 'Surabaya',
                'officer' => 'Renan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'PT. Broco Electrical Indonesia',
                'email' => 'broco@gmail.com',
                'phone' => '08213354678',
                'address' => 'Banten',
                'officer' => 'Broman',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        Supplier::insert($suppliers);
    }
}
