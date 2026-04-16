<?php

namespace Database\Seeders;

use App\Enums\OrderCategory;
use App\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $material = [
            [
                'material_category_id' => 1,
                'name' => 'Beras',
                'description' => '',
                'display_unit' => 'Kg',
                'conversion' => '1000',
                'order_category' => OrderCategory::DAILY->value,
            ],
            [
                'material_category_id' => 1,
                'name' => 'Kentang',
                'description' => '',
                'display_unit' => 'Kg',
                'conversion' => '1000',
                'order_category' => OrderCategory::DAILY->value,
            ],
        ];

        foreach ($material as $val) {
            Material::create([
                'material_category_id' => $val['material_category_id'],
                'name' => $val['name'],
                'description' => $val['description'],
                'qty_gram' => 0,
                'display_unit' => $val['display_unit'],
                'conversion' => $val['conversion'],
                'order_category' => $val['order_category'],
            ]);
        }
    }
}
