<?php

namespace Database\Seeders;

use App\Models\Posyandu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posyandu_data = [
            ['posyandu_code' => '001/PSY-CPK','posyandu_name' => 'Rindu','address' => 'Cililitan, Bahara','cadre_name' => 'Ulfatunnisa','cadre_phone_number' => '82117912781','cadre_email' => ''],
            ['posyandu_code' => '002/PSY-CPK','posyandu_name' => 'Karang Rahayu','address' => 'Bahara, Bahara','cadre_name' => 'Evi','cadre_phone_number' => '82130761152','cadre_email' => ''],
            ['posyandu_code' => '003/PSY-CPK','posyandu_name' => 'Jembar Sari','address' => 'Jongorsari, Bahara','cadre_name' => 'Sandra','cadre_phone_number' => '87881648116','cadre_email' => ''],
            ['posyandu_code' => '004/PSY-CPK','posyandu_name' => 'Linggka Kencana','address' => 'Sukaluyu, Bahara','cadre_name' => 'Bu Lurah','cadre_phone_number' => '81224209757','cadre_email' => ''],
            ['posyandu_code' => '005/PSY-CPK','posyandu_name' => 'Kamulyaan','address' => 'Karang Tawang, Bahara','cadre_name' => 'Nonoh','cadre_phone_number' => '82216348881','cadre_email' => ''],
        ];

        foreach ($posyandu_data as $val) {
            Posyandu::create([
                'posyandu_code' => $val['posyandu_code'],
                'posyandu_name' => $val['posyandu_name'],
                'address' => $val['address'],
                'cadre_name' => $val['cadre_name'],
                'cadre_phone_number' => $val['cadre_phone_number'],
                'cadre_email' => $val['cadre_email'],
            ]);
        }
    }
}
