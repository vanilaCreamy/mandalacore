<?php

namespace Database\Seeders;

use App\Models\MaterialCategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Karbohidrat',
                'abbr' => 'CHO',
                'description' => 'Sumber utama energi dari bahan pangan seperti beras, jagung, gandum, dan umbi-umbian.'
            ],
            [
                'name' => 'Protein Hewani',
                'abbr' => 'PH',
                'description' => 'Sumber protein yang berasal dari hewan seperti daging, ayam, ikan, telur, dan hasil laut.'
            ],
            [
                'name' => 'Protein Nabati',
                'abbr' => 'PN',
                'description' => 'Sumber protein yang berasal dari tumbuhan seperti kacang-kacangan, tahu, tempe, dan biji-bijian.'
            ],
            [
                'name' => 'Sayur',
                'abbr' => 'SYR',
                'description' => 'Kelompok bahan pangan berupa sayuran segar yang kaya serat, vitamin, dan mineral.'
            ],
            [
                'name' => 'Buah',
                'abbr' => 'BUH',
                'description' => 'Kelompok bahan pangan berupa buah-buahan yang mengandung vitamin, mineral, dan antioksidan.'
            ],
            [
                'name' => 'Bumbu',
                'abbr' => 'BMB',
                'description' => 'Bahan pelengkap masakan yang digunakan untuk memberikan rasa dan aroma pada makanan.'
            ],
            [
                'name' => 'Susu',
                'abbr' => 'SUS',
                'description' => 'Produk berbasis susu yang menjadi sumber kalsium, protein, dan nutrisi penting lainnya.'
            ],
        ];

        foreach ($categories as $cat) {
            MaterialCategory::create([
                'name' => $cat['name'],
                'abbr' => $cat['abbr'],
                'description' => $cat['description'],
            ]);
        }
    }
}
