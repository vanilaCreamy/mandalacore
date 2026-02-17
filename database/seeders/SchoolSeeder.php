<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools_data = [
            ['school_code' => '001/I/SKL-CPK','school_name' => 'KOBER AL HIDAYAH','address' => 'Dsn. Balandongan Rt.03 Rw. 02 Ds. Mandalare Kec. Panjalu Kab. Ciamis','school_level' => 'I','small_portions' => 24,'big_portions' => 0,'teacher_portions' => 4,'non_teacher_portions' => 0,'pic_name' => 'Imas Samrotul Fuadah, S.Pd','pic_position' => 'Kepala Sekolah','pic_phone_number' => '81222271307','pic_email' => 'imassamrotul09@gmail.com','hm_name' => 'Imas Samrotul Fuadah, S.Pd','hm_phone_number' => '81222271307','hm_email' => 'imassamrotul09@gmail.com'],
            ['school_code' => '002/II/SKL-CPK','school_name' => 'SDN 4 CIOMAS','address' => 'Dsn. Ciomas Landeuh Rt 20/ 19 Desa Ciomas Kec. Panjalu','school_level' => 'II','small_portions' => 33,'big_portions' => 36,'teacher_portions' => 11,'non_teacher_portions' => 1,'pic_name' => 'Herlin, S.P','pic_position' => 'Guru','pic_phone_number' => '81321261283','pic_email' => 'herlin521@guru.sd.belajar.id','hm_name' => 'Lies Andriani, S.Pd.SD','hm_phone_number' => '82117167727','hm_email' => 'lies.andriani14@admin.sd.belajar.id'],
            ['school_code' => '003/I/SKL-CPK','school_name' => 'KOBER RIYADLUL JANNAH','address' => 'Dusun Baros Rt 16 Rw 07 Desa Ciomas Kecamatan Panjalu Kabupaten Ciamis','school_level' => 'I','small_portions' => 26,'big_portions' => 0,'teacher_portions' => 7,'non_teacher_portions' => 0,'pic_name' => 'Syifa Iklima','pic_position' => 'Operator/ Guru','pic_phone_number' => '85861023832','pic_email' => 'syifaiklima6@gmail.com','hm_name' => 'Elis Susilawati S.Pd','hm_phone_number' => '81312103649','hm_email' => 'elissusilawati1971@gmail.com'],
            ['school_code' => '004/II/SKL-CPK','school_name' => 'SD NEGERI 7 PANJALU','address' => 'Dsn. Parcariang Desa/Kec. Panjalu Kab. Ciamis','school_level' => 'II','small_portions' => 23,'big_portions' => 27,'teacher_portions' => 8,'non_teacher_portions' => 0,'pic_name' => 'Guntur Irianto, S.Pd.I','pic_position' => 'Guru','pic_phone_number' => '82120034993','pic_email' => 'gunturgamarazta@gmail.com','hm_name' => 'Rina Risnawati, S.Pd','hm_phone_number' => '82219119925','hm_email' => 'rinarisnawati823@gmail.com'],
            ['school_code' => '005/I/SKL-CPK','school_name' => 'TK NURUL HUDA','address' => 'Dusun Banjar Rt 20 Rw 07','school_level' => 'I','small_portions' => 26,'big_portions' => 0,'teacher_portions' => 2,'non_teacher_portions' => 0,'pic_name' => 'Aan Nurjasanah','pic_position' => 'Guru','pic_phone_number' => '81298817871','pic_email' => 'aanelestohary14@gmail.com','hm_name' => 'Encep Muhamad Romli, S. H','hm_phone_number' => '852237037777','hm_email' => 'nh.daarulyatama@gmail.com'],
        ];


        foreach ($schools_data as $value) {
            School::create([
                'school_code' => $value['school_code'],
                'school_name' => $value['school_name'],
                'address' => $value['address'],
                'school_level' => $value['school_level'],
                'small_portions' => $value['small_portions'],
                'big_portions' => $value['big_portions'],
                'teacher_portions' => $value['teacher_portions'],
                'non_teacher_portions' => $value['non_teacher_portions'],
                'pic_name' => $value['pic_name'],
                'pic_position' => $value['pic_position'],
                'pic_phone_number' => $value['pic_phone_number'],
                'pic_email' => $value['pic_email'],
                'hm_name' => $value['hm_name'],
                'hm_phone_number' => $value['hm_phone_number'],
                'hm_email' => $value['hm_email'],
            ]);
        }
    }
}
