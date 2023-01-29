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
                'min_stock' => 10,
                'max_stock' => 50,
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
                'min_stock' => 40,
                'max_stock' => 100,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'categories_id' => 3,
                'measurements_id' => 3,
                'material_code' => 'BB.00'. 3,
                'name' => 'Panel A',
                'stock' => 0,
                'price' => 0,
                'min_stock' => 0,
                'max_stock' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        Material::insert($materials);
    }
}
