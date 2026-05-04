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
            ['material_category_id' => 1, 'name' => 'Beras', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '15000', 'order_category' => 'DAILY',],
            ['material_category_id' => 1, 'name' => 'Kentang', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '20000', 'order_category' => 'DAILY',],
            ['material_category_id' => 12, 'name' => 'Roti Tawar 40g', 'description' => '…', 'display_unit' => 'Lembar', 'conversion' => '50', 'updated_price' => '1200', 'order_category' => 'DAILY',],
            ['material_category_id' => 12, 'name' => 'Roti Pizza', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '100', 'updated_price' => '3000', 'order_category' => 'DAILY',],
            ['material_category_id' => 10, 'name' => 'Tepung Terigu', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '12000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 10, 'name' => 'Tepung Panir', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '21500', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 10, 'name' => 'Tepung Beras', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '12000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 10, 'name' => 'Tepung Tapioka', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '13000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 10, 'name' => 'Tepung Maizena', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '16000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Sasa Tepung Bumbu Serbaguna 70g', 'description' => '…', 'display_unit' => 'Renceng', 'conversion' => '700', 'updated_price' => '30000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 12, 'name' => 'Roti Abon', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '100', 'updated_price' => '3000', 'order_category' => 'DAILY',],
            ['material_category_id' => 2, 'name' => 'Ayam Fillet', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '59000', 'order_category' => 'DAILY',],
            ['material_category_id' => 2, 'name' => 'Ayam Potong', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '42000', 'order_category' => 'DAILY',],
            ['material_category_id' => 6, 'name' => 'Telur Ayam', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '29750', 'order_category' => 'DAILY',],
            ['material_category_id' => 12, 'name' => 'Kue Bolu Bonita 30g', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '30', 'updated_price' => '2000', 'order_category' => 'DAILY',],
            ['material_category_id' => 6, 'name' => 'Telur Asin', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '67', 'updated_price' => '4000', 'order_category' => 'DAILY',],
            ['material_category_id' => 7, 'name' => 'Tahu Putih', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '50', 'updated_price' => '850', 'order_category' => 'DAILY',],
            ['material_category_id' => 7, 'name' => 'Tahu Kuning', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '50', 'updated_price' => '850', 'order_category' => 'DAILY',],
            ['material_category_id' => 7, 'name' => 'Tahu Pong', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '50', 'updated_price' => '850', 'order_category' => 'DAILY',],
            ['material_category_id' => 7, 'name' => 'Tempe', 'description' => '…', 'display_unit' => 'Papan', 'conversion' => '350', 'updated_price' => '4500', 'order_category' => 'DAILY',],
            ['material_category_id' => 5, 'name' => 'Jeruk', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '30000', 'order_category' => 'DAILY',],
            ['material_category_id' => 5, 'name' => 'Kelengkeng', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '58000', 'order_category' => 'DAILY',],
            ['material_category_id' => 5, 'name' => 'Melon', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '23000', 'order_category' => 'DAILY',],
            ['material_category_id' => 5, 'name' => 'Semangka Merah', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '18500', 'order_category' => 'DAILY',],
            ['material_category_id' => 5, 'name' => 'Pear', 'description' => '…', 'display_unit' => 'Buah', 'conversion' => '260', 'updated_price' => '5500', 'order_category' => 'DAILY',],
            ['material_category_id' => 5, 'name' => 'Apel Fuji', 'description' => '…', 'display_unit' => 'Buah', 'conversion' => '145', 'updated_price' => '5000', 'order_category' => 'DAILY',],
            ['material_category_id' => 5, 'name' => 'Anggur Muscat', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '70000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Labu Siam', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '11000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Buncis', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '16000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Wortel', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '16500', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Selada', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '29000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Tomat', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '15000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Timun', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '10000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Kol', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '10500', 'order_category' => 'DAILY',],
            ['material_category_id' => 8, 'name' => 'Daun Bawang', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '19000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Kembang Kol', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '17000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Pakcoy', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '16000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Tauge', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '15000', 'order_category' => 'DAILY',],
            ['material_category_id' => 8, 'name' => 'Kemangi', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '24000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Sawi Putih', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '10000', 'order_category' => 'DAILY',],
            ['material_category_id' => 9, 'name' => 'Garam 250g', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '250', 'updated_price' => '3000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Gula Pasir', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '21000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Gula Merah', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '29000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Ladaku Merica Bubuk 2,5g', 'description' => '…', 'display_unit' => 'Renceng', 'conversion' => '30', 'updated_price' => '12000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Ladaku Lada Hitam Bubuk 250g', 'description' => '…', 'display_unit' => 'Pouch', 'conversion' => '250', 'updated_price' => '145000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Bawang Putih', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '34000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Bawang Merah', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '31000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Bawang Bombay', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '36000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Seledri', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '36000', 'order_category' => 'DAILY',],
            ['material_category_id' => 9, 'name' => 'Bawang Goreng', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '32000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Kunyit', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '15000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Jahe', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '25000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Kemiri', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '55000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Lengkuas', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '20000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Jeruk Nipis', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '18000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Daun Jeruk', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '45000', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Jamur Kuping', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '21500', 'order_category' => 'DAILY',],
            ['material_category_id' => 9, 'name' => 'Oregano Bubuk 50g', 'description' => '…', 'display_unit' => 'Botol', 'conversion' => '50', 'updated_price' => '17000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Royco Ayam 250g', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '250', 'updated_price' => '13500', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Royco Ayam 220g', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '220', 'updated_price' => '11000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Bumbu Racik Tempe Goreng 20g', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '20', 'updated_price' => '5000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 11, 'name' => 'Mentega', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '27000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Saori Saus Tiram 1L', 'description' => '…', 'display_unit' => 'Botol', 'conversion' => '1200', 'updated_price' => '75000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Saori Saus Teriyaki 1L', 'description' => '…', 'display_unit' => 'Botol', 'conversion' => '1200', 'updated_price' => '62000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Kecap Asin ABC 620ml', 'description' => '…', 'display_unit' => 'Botol', 'conversion' => '744', 'updated_price' => '35000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Desaku Kunyit Bubuk 100g', 'description' => '…', 'display_unit' => 'Pouch', 'conversion' => '100', 'updated_price' => '12000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Delmonte Saus Tomat 1Kg', 'description' => '…', 'display_unit' => 'Puch', 'conversion' => '1000', 'updated_price' => '23000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Cabe Merah Besar', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '65000', 'order_category' => 'DAILY',],
            ['material_category_id' => 8, 'name' => 'Kencur', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '55000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 11, 'name' => 'Minyak Goreng', 'description' => '…', 'display_unit' => 'Ltr', 'conversion' => '900', 'updated_price' => '24000', 'order_category' => 'DAILY',],
            ['material_category_id' => 14, 'name' => 'Frisian Flag Nutribrain Omega 110ml', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '115.5', 'updated_price' => '3500', 'order_category' => 'DAILY',],
            ['material_category_id' => 14, 'name' => 'Ultra Milk 125ml', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '131.25', 'updated_price' => '3500', 'order_category' => 'DAILY',],
            ['material_category_id' => 14, 'name' => 'Ultra Milk 200ml', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '210', 'updated_price' => '5800', 'order_category' => 'DAILY',],
            ['material_category_id' => 9, 'name' => 'Biji Wijen', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '45000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Kecap Inggris ABC 195ml', 'description' => '…', 'display_unit' => 'Botol', 'conversion' => '234', 'updated_price' => '16500', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Kecap Asin ABC 133ml', 'description' => '…', 'display_unit' => 'Botol', 'conversion' => '159.6', 'updated_price' => '14500', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 4, 'name' => 'Jagung Muda', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '37000', 'order_category' => 'DAILY',],
            ['material_category_id' => 12, 'name' => 'Bakso', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '50', 'updated_price' => '650', 'order_category' => 'DAILY',],
            ['material_category_id' => 5, 'name' => 'Buah Naga', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '22000', 'order_category' => 'DAILY',],
            ['material_category_id' => 5, 'name' => 'Pisang Cavendish', 'description' => '…', 'display_unit' => 'Buah', 'conversion' => '120', 'updated_price' => '3500', 'order_category' => 'DAILY',],
            ['material_category_id' => 1, 'name' => 'Dimsum', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '100', 'updated_price' => '1250', 'order_category' => 'DAILY',],
            ['material_category_id' => 1, 'name' => 'Rolade', 'description' => '…', 'display_unit' => 'Pcs', 'conversion' => '100', 'updated_price' => '2500', 'order_category' => 'DAILY',],
            ['material_category_id' => 4, 'name' => 'Jagung Pipil', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '21500', 'order_category' => 'DAILY',],
            ['material_category_id' => 9, 'name' => 'Cuka Dixi 650ml', 'description' => '…', 'display_unit' => 'Botol', 'conversion' => '650', 'updated_price' => '17500', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Kecap Manis Bango 700g', 'description' => '…', 'display_unit' => 'Pouch', 'conversion' => '700', 'updated_price' => '27000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 9, 'name' => 'Kecap Manis Bango 1.5kg', 'description' => '…', 'display_unit' => 'Pouch', 'conversion' => '1500', 'updated_price' => '55000', 'order_category' => 'WEEKLY',],
            ['material_category_id' => 8, 'name' => 'Jeruk Limau', 'description' => '…', 'display_unit' => 'Kg', 'conversion' => '1000', 'updated_price' => '30000', 'order_category' => 'DAILY',],
            ['material_category_id' => 9, 'name' => 'Desaku Ketumbar Bubuk', 'description' => '…', 'display_unit' => 'Renceng', 'conversion' => '6', 'updated_price' => '2000000', 'order_category' => 'WEEKLY',],

        ];

        foreach ($material as $val) {
            Material::create([
                'material_category_id' => $val['material_category_id'],
                'name' => $val['name'],
                'description' => $val['description'],
                'qty_gram' => 0,
                'display_unit' => $val['display_unit'],
                'conversion' => $val['conversion'],
                'updated_price' => $val['updated_price'],
                'order_category' => $val['order_category'],
            ]);
        }
    }
}
