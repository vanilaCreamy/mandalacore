<?php

namespace Database\Seeders;

use App\enum\UserRole;
use App\Models\User;
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
            ['name' => 'Fuza Nur Uswah Azizah', 'email' => 'www.pudja@gmail.com', 'role' => UserRole::PLOG],
            ['name' => 'Dani Nugraha', 'email' => 'nugrahadani563@gmail.com', 'role' => UserRole::PLOK],
            ['name' => 'Mahesa Dwi Putra', 'email' => 'mahesadwi26@gmail.com', 'role' => UserRole::ASLAP],

            // Operasional
            ['name' => 'Adad Arsyad','email' => 'adadarsyad991@gmail.com','role' => 'PEMORSIAN'],
            ['name' => 'Aditia Robiana','email' => 'robiana329@gmail.com','role' => 'PENGOLAHAN'],
            ['name' => 'Ahmad Fauzi','email' => 'aslandfaufau@gmail.com','role' => 'PENCUCIAN'],
            ['name' => 'Ani Mulyani','email' => 'heniihenii643@gmail.com','role' => 'PENGOLAHAN'],
            // ['name' => 'Anisa','email' => 'anismnd70@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Ariep Pajaruddin Ramadhan','email' => 'dikeudarmarai07@gmail.com','role' => 'PENCUCIAN'],
            // ['name' => 'Cucu Ernawati','email' => 'ahciu97@gmail.com','role' => 'PENCUCIAN'],
            // ['name' => 'Dea','email' => 'deaya245@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Dela Puspita Dewi','email' => 'sardeldela@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Dikeu Darmarai','email' => 'dikeudarmarai@gmail.com','role' => 'PENCUCIAN'],
            // ['name' => 'Dina Nuraeni','email' => 'dinanrni93@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Entis Sutisna','email' => 'ryantiez55@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Fitri Komala Fauziyah','email' => 'nengrayafitria@gmail.com','role' => 'PERSIAPAN'],
            // ['name' => 'Imas Masitoh','email' => 'imas04191@gmail.com','role' => 'PERSIAPAN'],
            // ['name' => 'Iros Rosita','email' => 'irosrosita11ipa2@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Lia Muryati','email' => 'liyanackal@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Lina Andriyani','email' => 'linaandriyani51@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Mimi','email' => 'aryawiguna2444@gmail.com','role' => 'PENCUCIAN'],
            // ['name' => 'Nene Solihat','email' => 'solihatnene@gmail.com','role' => 'PENGOLAHAN'],
            // ['name' => 'Rega Gumelar','email' => 'regaabehollderr@gmail.com','role' => 'DISTRIBUSI'],
            // ['name' => 'Rini Nuraeni','email' => 'rininuraini810@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Salma Salafina','email' => 'salmasalafina624@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Sri Restu Handayani','email' => 'handayanisrirestu@gmail.com','role' => 'PERSIAPAN'],
            // ['name' => 'Tuti Haryati','email' => 'tuti194720@gmail.com','role' => 'PERSIAPAN'],
            // ['name' => 'Winda Nurhayati','email' => 'nurhayatiwinda132@gmail.com','role' => 'PEMORSIAN'],
            // ['name' => 'Wini Oktaviani','email' => 'winioktaviani1998@gmail.com','role' => 'PENGOLAHAN'],
            // ['name' => 'Yani','email' => 'mamahbel88@gmail.com','role' => 'PENGOLAHAN'],
            // ['name' => 'Yayah Rukoyah','email' => 'tiararizkyrahayu@gmail.com','role' => 'PENCUCIAN'],
            // ['name' => 'Yogi Suryana','email' => 'suryanayogi44@gmail.com','role' => 'DISTRIBUSI'],
            // ['name' => 'Yuni Juniyanti','email' => 'yuniinoy20@gmail.com','role' => 'PERSIAPAN'],
            // ['name' => 'Yuyun Siti Yunaningsih','email' => 'sitiyunaningsihyuyun@gmail.com','role' => 'PERSIAPAN'],
            // ['name' => 'Zidan Putra Ramadhan','email' => 'zidanputraramadhan83@gmail.com','role' => 'PERSIAPAN'],
            // ['name' => 'Nurhayati','email' => 'mamahguji@gmail.com','role' => 'PERSIAPAN'],
            // ['name' => 'Afrizal','email' => 'anggianggiasari2@gmail.com','role' => 'PENCUCIAN'],
            // ['name' => 'Wulan Fadilah Agustiena','email' => 'wulanfadilah885@gmail.com','role' => 'PERSIAPAN'],
            // ['name' => 'Sultan Bara Yudayana','email' => 'sultanbara11106@gmail.com','role' => 'PENCUCIAN'],
            // ['name' => 'Ivan Maulana','email' => '1997.maulanaz@gmail.com','role' => 'PENCUCIAN'],
            // ['name' => 'Indra Alamsyah','email' => 'ia9355894@gmail.com','role' => 'PENGOLAHAN'],
            // ['name' => 'Nova Yani Fauziah','email' => 'nopyanifauziah@gmail.com','role' => 'PENGOLAHAN'],
            // ['name' => 'Pipin','email' => 'pipinqt@gmail.com','role' => 'PENCUCIAN'],

        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => $user['role'],
            ]);
        }
    }
}
