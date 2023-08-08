<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materials = [
            [
                'categories_id' => 1,
                'measurements_id' => 1,
                'material_code' => 'BB.00'. 1,
                'name' => 'MCB 40A',
                'stock' => 30,
                'price' => 285000,
                'old_price' => NULL,
                'change_price' => NULL,
                'min_stock' => 10,
                'max_stock' => 50,
                'pr_status' => NULL,
                'price_approval' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'categories_id' => 2,
                'measurements_id' => 2,
                'material_code' => 'BP.00'. 2,
                'name' => 'Pilot Lamp',
                'stock' => 50,
                'price' => 48000,
                'old_price' => NULL,
                'change_price' => NULL,
                'min_stock' => 40,
                'max_stock' => 100,
                'pr_status' => NULL,
                'price_approval' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'categories_id' => 1,
                'measurements_id' => 1,
                'material_code' => 'BB.00'. 3,
                'name' => 'Busbar',
                'stock' => 30,
                'price' => 460000,
                'old_price' => NULL,
                'change_price' => NULL,
                'min_stock' => 20,
                'max_stock' => 40,
                'pr_status' => NULL,
                'price_approval' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'categories_id' => 1,
                'measurements_id' => 1,
                'material_code' => 'BB.00'. 4,
                'name' => 'Stop Emergency',
                'stock' => 50,
                'price' => 35000,
                'old_price' => NULL,
                'change_price' => NULL,
                'min_stock' => 30,
                'max_stock' => 50,
                'pr_status' => NULL,
                'price_approval' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        Material::insert($materials);
    }
}
