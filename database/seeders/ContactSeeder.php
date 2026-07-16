<?php

namespace Database\Seeders;

use App\Models\ContactSekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataContact = [
            [
                'icon' => 'https://img.icons8.com/?size=100&id=X0mEIh0RyDdL&format=png&color=000000',
                'name' => 'sdncaringin@gmail.com',
                'link' => 'mailto:sdncaringin@gmail.com',
            ],
            [
                'icon' => 'https://img.icons8.com/fluent/48/000000/whatsapp.png',
                'name' => '082233445566',
                'link' => 'https://wa.me/6282233445566',
            ],
            [
                'icon' => 'https://img.icons8.com/fluent/48/000000/instagram-new.png',
                'name' => '@sdncaringin',
                'link' => 'https://instagram.com/sdncaringin',
            ],
            [
                'icon' => 'https://img.icons8.com/fluent/48/000000/facebook-new.png',
                'name' => 'sdncaringin',
                'link' => 'https://facebook.com/sdncaringin',
            ],
            [
                'icon' => 'https://img.icons8.com/fluent/48/000000/youtube-play.png',
                'name' => 'sdncaringin',
                'link' => 'https://youtube.com/sdncaringin',
            ],
        ];

        foreach ($dataContact as $val) {
            ContactSekolah::create($val);
        }
    }
}
