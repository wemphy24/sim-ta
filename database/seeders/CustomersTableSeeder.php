<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [
                'name' => 'PT. Navara Hotel',
                'email' => 'navatel@gmail.com',
                'phone' => '089123456789',
                'address' => 'Bali',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Bali Med',
                'email' => 'balimed@gmail.com',
                'phone' => '089987654321',
                'address' => 'Bali',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'PT. Swiss Bell',
                'email' => 'swissbell@gmail.com',
                'phone' => '081987654321',
                'address' => 'Jakarta',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        Customer::insert($customers);
    }
}
