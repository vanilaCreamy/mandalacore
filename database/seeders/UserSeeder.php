<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'role' => UserRole::ADMIN],

            // Staf Management
            ['name' => 'Kevin Egy Mayo', 'email' => 'kevin@gmail.com', 'role' => UserRole::KEPALA],
            ['name' => 'Pudja Nur Uswah Azizah', 'email' => 'www.pudja@gmail.com', 'role' => UserRole::PLOG],
            ['name' => 'Dani Nugraha', 'email' => 'nugrahadani563@gmail.com', 'role' => UserRole::PLOK],
            ['name' => 'Mahesa Dwi Putra', 'email' => 'mahesadwi26@gmail.com', 'role' => UserRole::ASLAP],

            // Operasional

            // PERSIAPAN
            ['name' => 'Wulan Fadilah Agustiena','email' => 'wulanfadilah885@gmail.com','role' => 'PERSIAPAN'],
            ['name' => 'Nurhayati','email' => 'mamahguji@gmail.com','role' => 'PERSIAPAN'],
            ['name' => 'Fitri Komala Fauziyah','email' => 'nengrayafitria@gmail.com','role' => 'PERSIAPAN'],
            ['name' => 'Nurhayati','email' => 'nh067541@gmail.com','role' => 'PERSIAPAN'],
            ['name' => 'Imas Masitoh','email' => 'imassyifa22@gmail.com','role' => 'PERSIAPAN'],
            ['name' => 'Yuni Juniyanti','email' => 'yuniinoy20@gmail.com','role' => 'PERSIAPAN'],
            ['name' => 'Zidan Putra Ramadhan','email' => 'zidanputraramadhan83@gmail.com','role' => 'PERSIAPAN'],
            ['name' => 'Sri Restu Handayani','email' => 'restuhandayanisri339@gmail.com','role' => 'PERSIAPAN'],
            ['name' => 'Tuti Haryati','email' => 'tuti194720@gmail.com','role' => 'PERSIAPAN'],
            ['name' => 'Dandi','email' => 'doankd357@gmail.com','role' => 'PERSIAPAN'],

            // PENGOLAHAN
            ['name' => 'Wini Oktaviani','email' => 'winioktaviani1998@gmail.com','role' => 'PENGOLAHAN'],
            ['name' => 'Aditia Robiana','email' => 'robiana329@gmail.com','role' => 'PENGOLAHAN'],
            ['name' => 'Yuyun Siti Yunaningsih','email' => 'sitiyunaningsihyuyun@gmail.com','role' => 'PENGOLAHAN'],
            ['name' => 'Nova Yani Fauziah','email' => 'nopyanifauziah@gmail.com','role' => 'PENGOLAHAN'],
            ['name' => 'Indra Alamsyah','email' => 'ia9355894@gmail.com','role' => 'PENGOLAHAN'],
            ['name' => 'Yani','email' => 'jejenbellabellaaj@gmail.com','role' => 'PENGOLAHAN'],
            ['name' => 'Ani Mulyani','email' => 'heniihenii643@gmail.com','role' => 'PENGOLAHAN'],

            // PEMORSIAN
            ['name' => 'Lia Muryati','email' => 'liyanackal@gmail.com','role' => 'PEMORSIAN'],
            ['name' => 'Dina Nuraeni','email' => 'dinanrni93@gmail.com','role' => 'PEMORSIAN'],
            ['name' => 'Dea','email' => 'deaya245@gmail.com','role' => 'PEMORSIAN'],
            ['name' => 'Rini Nuraeni','email' => 'rininuraini810@gmail.com','role' => 'PEMORSIAN'],
            ['name' => 'Salma Salafina','email' => 'salmasalafina624@gmail.com','role' => 'PEMORSIAN'],
            ['name' => 'Iros Rosita','email' => 'its.rosita28@gmail.com','role' => 'PEMORSIAN'],
            ['name' => 'Lina Andriyani','email' => 'linaandriyani51@gmail.com','role' => 'PEMORSIAN'],
            ['name' => 'Winda Nurhayati','email' => 'windnrhytii@gmail.com','role' => 'PEMORSIAN'],
            ['name' => 'Anisa','email' => 'anismnd70@gmail.com','role' => 'PEMORSIAN'],

            // DISTRIBUSI
            ['name' => 'Hilman Abdurahman','email' => 'hilmanabdurrahman262@gmail.com','role' => 'DISTRIBUSI'],
            ['name' => 'Angga Maulana','email' => 'nicetry.angga27@gmail.com','role' => 'DISTRIBUSI'],
            ['name' => 'Rega Gumelar','email' => 'regaabehollderr@gmail.com','role' => 'DISTRIBUSI'],
            ['name' => 'Yogi Suryana','email' => 'suryanayogi44@gmail.com','role' => 'DISTRIBUSI'],

            // PENCUCIAN
            ['name' => 'Ahmad Fauzi','email' => 'aslandfaufau@gmail.com','role' => 'PENCUCIAN'],
            ['name' => 'Irvan Maulana','email' => '1997.maulanaz@gmail.com','role' => 'PENCUCIAN'],
            ['name' => 'Dikeu Darmarai','email' => 'dikeudarmarai@gmail.com','role' => 'PENCUCIAN'],
            ['name' => 'Ariep Fajarudin Ramadhan','email' => 'fajarrmdhn09@gmail.com','role' => 'PENCUCIAN'],
            ['name' => 'Aprijal','email' => 'apriijall1421@gmail.com','role' => 'PENCUCIAN'],
            ['name' => 'Sultan Bara Yudayana','email' => 'sultanbara11106@gmail.com','role' => 'PENCUCIAN'],
            ['name' => 'Cucu Ernawati','email' => 'ahciu97@gmail.com','role' => 'PENCUCIAN'],
            ['name' => 'Yayah Rukiyah','email' => 'tiararizkyrahayu@gmail.com','role' => 'PENCUCIAN'],
            
            // KEAMANAN
            ['name' => 'Randi','email' => 'tiararizkyrahayu@gmail.com','role' => 'PENCUCIAN'],
            
            // KEBERSIHAN
            ['name' => 'Mimi','email' => 'm99328657@gmail.com','role' => 'KEBERSIHAN'],


        ];

        foreach ($users as $user) {
            $new_user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => $user['role'],
            ]);

            UserInformation::create([
                'user_id' => $new_user->id,
            ]);
        }
    }
}
