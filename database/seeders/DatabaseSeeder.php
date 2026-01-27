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
            'site_name' => 'JadiCMS',
            'tagline' => 'Laravel Power, Inertia Speed. The Modern Stack, Simplified.',
            'icon' => '/favicon.ico',
            'meta_keywords' => 'JadiCMS, Laravel, Inertia, PHP, CMS',
            'meta_description' => 'JadiCMS is a modern CMS built with Laravel and Inertia.',
            'meta_tags' => '{}',
        ];

        foreach ($settings as $key => $value) {
            j_set_option($key, $value);
        }


        //  $this->call(PageCommonSeeder::class);

        echo "Database seeded successfully.\n";
        echo "|-------------------------------------|\n";
        echo "| Admin URL: " . url('/admin') . "      |\n";
        echo "|-------------------------------------|\n";
        echo "| Login: admin@jadicms.com            |\n";
        echo "| Password: password                  |\n";
        echo "|-------------------------------------|\n";
    }
}
