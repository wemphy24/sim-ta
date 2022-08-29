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
                'name' => 'Pilot Lamp',
                'stock' => 50,
                'price' => 48000,
                'min_stock' => 80,
                'max_stock' => 100,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        Material::insert($materials);
    }
}
