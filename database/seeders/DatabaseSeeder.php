<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'administrator',
            'email' => 'admin@saiyamusic.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);



        // menu
        j_set_option('menus', json_encode([
            [
                'id' => 1,
                'label' => 'Home',
                'url' => '/',
                'is_parent' => false,
                'parent_id' => null
            ],
            [
                'id' => 2,
                'label' => 'Products',
                'url' => '/products',
                'is_parent' => false,
                'parent_id' => null
            ],
            [
                'id' => 4,
                'label' => 'About Us',
                'url' => '/page/about-us',
                'is_parent' => false,
                'parent_id' => null
            ]
        ]));

        // setting
        $settings = [
            'base_url' => url('/'),
            'site_name' => 'Saiya Music',
            'tagline' => 'PT SAIYA INDONESIA',
            'icon' => '/favicon.ico',
            'meta_keywords' => 'PT SAIYA INDONESIA, Laravel, Inertia, PHP, CMS',
            'meta_description' => 'PT SAIYA INDONESIA is a modern CMS built with Laravel and Inertia.',
            'meta_tags' => '{}',
        ];

        foreach ($settings as $key => $value) {
            j_set_option($key, $value);
        }

        $this->call([
            BannerSeeder::class ,
            CategorySeeder::class ,
            PostSeeder::class ,
            ProductSeeder::class ,
        ]);


        Artisan::call('storage:link');
        j_set_option('active_theme', 'saiya');



        // offices seeder
        $offices = [
            [
                'name' => 'PT SAIYA INDONESIA ( Jepara )',
                'province' => 'Jawa Tengah',
                'city' => 'Jepara',
                'address' => 'JL. RMP SOSROKARTONO KM 3 RT 33,DESA KECAPI KEC. TAHUNAN',
                'phone' => '+62 291 596186',
                'email' => 'saiya_indonesia@yahoo.com',
                'map_url' => 'https://www.google.com/maps/place/saiya',
            ],
            [
                'name' => 'PT SAIYA INDONESIA ( Cirebon )',
                'province' => 'Jawa Barat',
                'city' => 'Cirebon',
                'address' => 'JL. PANGERAN ANTASARI KM 3 NO 29 DESA LURAH KEC. PLUMBON',
                'phone' => '+62 231 247263',
                'email' => 'saiya_indonesia@yahoo.com',
                'map_url' => 'https://www.google.com/maps/place/saiya',
            ]
        ];

        j_set_option('offices', json_encode($offices, JSON_PRETTY_PRINT));



        echo "Database seeded successfully.\n";
        echo "|-------------------------------------|\n";
        echo "| Admin URL: " . url('/admin') . "      |\n";
        echo "|-------------------------------------|\n";
        echo "| Login: admin@jadicms.com            |\n";
        echo "| Password: password                  |\n";
        echo "|-------------------------------------|\n";
    }
}