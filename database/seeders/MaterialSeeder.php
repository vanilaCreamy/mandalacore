<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $categories = DB::table('material_categories')
            ->pluck('id', 'name'); // ['Karbohidrat' => 1, ...]

        $materialsByCategory = [

            'Karbohidrat' => [
                'Beras Putih', 'Beras Merah', 'Beras Ketan', 'Jagung Pipil',
                'Tepung Terigu', 'Tepung Beras', 'Tepung Tapioka', 'Singkong',
                'Ubi Jalar', 'Kentang', 'Mie Kering', 'Mie Basah',
                'Bihun', 'Soun', 'Roti Tawar', 'Oatmeal', 'Gandum Utuh'
            ],

            'Protein Hewani' => [
                'Daging Sapi', 'Daging Ayam', 'Daging Kambing', 'Ikan Lele',
                'Ikan Nila', 'Ikan Tongkol', 'Ikan Kembung', 'Ikan Salmon',
                'Udang', 'Cumi', 'Telur Ayam', 'Telur Bebek',
                'Hati Ayam', 'Ati Ampela', 'Bakso Sapi', 'Sosis Ayam'
            ],

            'Protein Nabati' => [
                'Tahu Putih', 'Tahu Kuning', 'Tempe', 'Kacang Tanah',
                'Kacang Hijau', 'Kacang Merah', 'Kedelai', 'Edamame',
                'Kacang Mede', 'Kacang Almond', 'Kacang Polong'
            ],

            'Sayur' => [
                'Bayam', 'Kangkung', 'Sawi Hijau', 'Sawi Putih',
                'Wortel', 'Kol', 'Buncis', 'Kacang Panjang',
                'Labu Siam', 'Terong Ungu', 'Timun', 'Tomat',
                'Daun Singkong', 'Daun Pepaya', 'Brokoli', 'Kembang Kol',
                'Paprika Merah', 'Paprika Hijau', 'Selada', 'Daun Bawang',
                'Seledri'
            ],

            'Buah' => [
                'Pisang', 'Apel', 'Jeruk', 'Semangka', 'Melon',
                'Pepaya', 'Mangga', 'Nanas', 'Pir', 'Anggur',
                'Alpukat', 'Jambu Air', 'Jambu Biji', 'Salak'
            ],

            'Bumbu' => [
                'Bawang Merah', 'Bawang Putih', 'Bawang Bombay', 'Cabai Merah',
                'Cabai Rawit', 'Kemiri', 'Ketumbar', 'Merica',
                'Jahe', 'Kunyit', 'Lengkuas', 'Serai',
                'Daun Salam', 'Daun Jeruk', 'Garam', 'Gula Pasir',
                'Gula Merah', 'Kecap Manis', 'Saus Tiram', 'Minyak Goreng'
            ],

            'Susu' => [
                'Susu Cair', 'Susu Bubuk', 'Susu Kental Manis',
                'Keju Cheddar', 'Keju Mozarella', 'Yogurt',
                'Mentega', 'Margarin', 'Krimer'
            ],
        ];

        $displayUnits = [
            ['unit' => 'kg', 'conv' => 1000],
            ['unit' => 'gram', 'conv' => 1],
            ['unit' => 'ikat', 'conv' => 250],
            ['unit' => 'pcs', 'conv' => 100],
            ['unit' => 'liter', 'conv' => 1000],
        ];

        $rows = [];

        foreach ($materialsByCategory as $categoryName => $items) {
            foreach ($items as $item) {

                // Gandakan variasi supaya tembus 200+
                for ($i = 1; $i <= 3; $i++) {

                    $unit = $displayUnits[array_rand($displayUnits)];

                    $rows[] = [
                        'material_category_id' => $categories[$categoryName],
                        'name' => $item . ' ' . $i,
                        'description' => 'Bahan ' . strtolower($item) . ' untuk kebutuhan dapur.',
                        'qty_gram' => rand(0, 5000),
                        'display_unit' => $unit['unit'],
                        'conversion' => $unit['conv'],
                        'order_category' => 'daily', // sesuaikan dengan enum kamu
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        DB::table('materials')->insert($rows);
    }
}
