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
                'name' => 'Karbohidrat Utama',
                'abbr' => 'KBU',
                'description' => 'Sumber karbohidrat utama sebagai makanan pokok seperti beras, mie, kentang, jagung, dan turunannya.'
            ],
            [
                'name' => 'Lauk Hewani Segar',
                'abbr' => 'LHS',
                'description' => 'Bahan lauk hewani dalam kondisi segar seperti daging, ayam, ikan, dan hasil laut yang belum diolah.'
            ],
            [
                'name' => 'Lauk Nabati Segar',
                'abbr' => 'LNS',
                'description' => 'Bahan lauk nabati segar seperti tempe, tahu, dan bahan protein nabati lain yang belum diproses lanjut.'
            ],
            [
                'name' => 'Sayur Segar',
                'abbr' => 'SYS',
                'description' => 'Berbagai jenis sayuran segar yang digunakan sebagai bahan masakan harian.'
            ],
            [
                'name' => 'Buah Segar',
                'abbr' => 'BGS',
                'description' => 'Buah-buahan segar yang disajikan langsung atau sebagai pelengkap menu.'
            ],
            [
                'name' => 'Telur',
                'abbr' => 'TLR',
                'description' => 'Telur ayam, bebek, dan sejenisnya yang digunakan sebagai lauk atau bahan masakan.'
            ],
            [
                'name' => 'Produk Kedelai',
                'abbr' => 'PKD',
                'description' => 'Produk berbahan dasar kedelai seperti tahu, tempe, susu kedelai, dan turunannya.'
            ],
            [
                'name' => 'Bumbu Basah',
                'abbr' => 'BBA',
                'description' => 'Bumbu dengan kadar air tinggi seperti bawang, cabai, jahe, lengkuas, kunyit, dan sejenisnya.'
            ],
            [
                'name' => 'Bumbu Kering & Seasoning',
                'abbr' => 'BKS',
                'description' => 'Bumbu kering dan penyedap seperti garam, gula, merica, kaldu bubuk, dan rempah kering.'
            ],
            [
                'name' => 'Bahan Kering Produksi',
                'abbr' => 'BKP',
                'description' => 'Bahan kering pendukung produksi seperti tepung, maizena, tapioka, dan bahan pengental lainnya.'
            ],
            [
                'name' => 'Minyak & Lemak',
                'abbr' => 'MDL',
                'description' => 'Minyak goreng, margarin, mentega, dan sumber lemak lainnya untuk proses memasak.'
            ],
            [
                'name' => 'Produk Olahan Jadi',
                'abbr' => 'POJ',
                'description' => 'Produk yang sudah diolah dan siap pakai seperti sosis, nugget, bakso, dan makanan olahan lainnya.'
            ],
            [
                'name' => 'Santan & Produk Turunan Kelapa',
                'abbr' => 'STK',
                'description' => 'Santan, kelapa parut, dan bahan lain berbasis kelapa untuk kebutuhan masakan.'
            ],
            [
                'name' => 'Susu & Produk Susu',
                'abbr' => 'SPS',
                'description' => 'Susu cair, susu bubuk, keju, kental manis, dan produk turunan susu lainnya.'
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
