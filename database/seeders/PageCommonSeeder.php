<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Gemini\Laravel\Facades\Gemini;
use App\Models\User;
use App\Models\Post;

class PageCommonSeeder extends Seeder
{
    private function generatePage(string $title, string $slug)
    {
        $prompt = "
        Buatkan konten halaman website dengan judul: \"$title\"

        Format:
        ###EXCERPT###
        {excerpt}

        ###CONTENT###
        {content}
        ";

        $response = Gemini::generativeModel('gemini-2.0-flash')
            ->generateContent($prompt)
            ->text();

        // PARSE BLOCK
        preg_match('/###EXCERPT###([\s\S]*?)###CONTENT###/', $response, $m1);
        preg_match('/###CONTENT###([\s\S]*)/', $response, $m2);

        $excerpt = trim($m1[1] ?? '');
        $content = trim($m2[1] ?? '');

        return [
            'excerpt' => $excerpt,
            'content' => $content,
        ];
    }

    public function run(): void
    {
        $user = User::first() ?? User::create([
            'name' => 'AI System',
            'email' => 'system@example.com',
            'password' => bcrypt('password'),
        ]);

        $pages = [
            ['title' => 'About Us',       'slug' => 'about-us'],
            ['title' => 'Privacy Policy', 'slug' => 'privacy-policy'],
            ['title' => 'Contact Us',     'slug' => 'contact-us'],
        ];

        foreach ($pages as $p) {
            $generated = $this->generatePage($p['title'], $p['slug']);

            Post::updateOrCreate(
                ['slug' => $p['slug'], 'type' => 'page'], // prevent duplicate
                [
                    'title'   => $p['title'],
                    'type'    => 'page',
                    'slug'    => $p['slug'],
                    'content' => $generated['content'],
                    'excerpt' => $generated['excerpt'],
                    'user_id' => $user->id,
                ]
            );
        }

        echo "PageCommonSeeder executed.\n";
    }
}
