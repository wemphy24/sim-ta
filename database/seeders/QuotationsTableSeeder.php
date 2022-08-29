<?php

namespace Database\Seeders;

use App\Models\Quotation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuotationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quotations = [
            [
                'quotation_code' => 'QO.22082022.1001',
                'name' => 'Penawaran Panel A',
                'project' => 'Panel A',
                'date' => date('Y-m-d'),
                'location' => 'Bali',
                'customers_id' => 1,
                'status_id' => 1,
                'users_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'quotation_code' => 'QO.22082022.1002',
                'name' => 'Penawaran Panel B',
                'project' => 'Panel B',
                'date' => date('Y-m-d'),
                'location' => 'Bali',
                'customers_id' =>2,
                'status_id' => 1,
                'users_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        Quotation::insert($quotations);
    }
}
