<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Post;
use App\Models\Label;
use App\Models\Postmeta;
use App\Models\Labelmeta;
use App\Models\Media;
use App\Models\Comment;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // ----------------------------------------------------
        // USER
        // ----------------------------------------------------
        $user = User::first() ??
            User::create([
                'name' => 'Demo Author',
                'email' => 'author@example.com',
                'password' => bcrypt('password'),
            ]);

        // ----------------------------------------------------
        // LABELS (CATEGORIES & TAGS)
        // ----------------------------------------------------
        $categories = collect([
            'Technology',
            'Lifestyle',
            'Business',
            'Finance',
            'Travel',
        ])->map(function ($cat) {
            return Label::create([
                'taxonomy' => 'category',
                'name' => $cat,
                'slug' => Str::slug($cat),
            ]);
        });

        $tags = collect([
            'Laravel',
            'Vue',
            'Filament',
            'PHP',
            'JavaScript',
            'Tailwind',
            'MySQL'
        ])->map(function ($tag) {
            return Label::create([
                'taxonomy' => 'tag',
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        });

        // ----------------------------------------------------
        // LABEL META
        // ----------------------------------------------------
        foreach ($categories->merge($tags) as $label) {
            Labelmeta::create([
                'label_id' => $label->id,
                'meta_key' => 'color',
                'meta_value' => $faker->hexColor(),
            ]);
        }

        // ----------------------------------------------------
        // MEDIA (10 random images)
        // ----------------------------------------------------
        $mediaItems = collect([]);
        for ($i = 1; $i <= 10; $i++) {
            $mediaItems->push(
                Media::create([
                    'mime' => 'image/jpeg',
                    'path' => "/uploads/demo-$i.jpg",
                    'filename' => "demo-$i.jpg",
                    'size' => rand(100000, 300000),
                    'user_id' => $user->id,
                ])
            );
        }

        // ----------------------------------------------------
        // POSTS (faker realistic)
        // ----------------------------------------------------
        $posts = collect([]);

        for ($i = 1; $i <= 10; $i++) {
            $title = $faker->sentence(6);

            $post = Post::create([
                'type' => 'post',
                'title' => $title,
                'slug' => Str::slug($title . '-' . Str::random(5)),
                'image' => $mediaItems->random()->id,
                'content' => $faker->paragraphs(rand(3, 7), true),
                'excerpt' => $faker->sentence(12),
                'user_id' => $user->id,
            ]);

            $posts->push($post);

            // categories
            $post->labels()->attach($categories->random(rand(1, 2))->pluck('id')->toArray());

            // tags
            $post->labels()->attach($tags->random(rand(2, 5))->pluck('id')->toArray());

            // post meta
            Postmeta::create([
                'post_id' => $post->id,
                'meta_key' => 'views',
                'meta_value' => $faker->numberBetween(50, 2000),
            ]);
        }

        // ----------------------------------------------------
        // COMMENTS
        // ----------------------------------------------------
        foreach ($posts as $post) {
            for ($i = 1; $i <= rand(2, 5); $i++) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'content' => $faker->sentence(rand(5, 12)),
                ]);
            }
        }

        echo "Demo content generated using Faker.\n";
    }
}
