<?php

namespace Database\Seeders;

use App\Models\PortionBase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortionBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $base = [
            [
                'code' => 'PK',
                'name' => 'Porsi Kecil',
            ],
            [
                'code' => 'PB',
                'name' => 'Porsi Besar',
            ]
        ];

        foreach ($base as $val) {
            PortionBase::create([
                'code' => $val['code'],
                'name' => $val['name'],
            ]);
        }
    }
}
