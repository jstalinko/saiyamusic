<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Welcome to PT SAIYA INDONESIA: Crafting Musical Excellence',
                'slug' => 'welcome-to-pt-saiya-indonesia',
                'excerpt' => 'Discover the passion and craftsmanship behind Saiya Guitars, Indonesia\'s premier acoustic and electric instrument manufacturer.',
                'content' => '
                    <p>At <strong>PT SAIYA INDONESIA</strong>, we believe that every guitar has a soul. Established with a profound passion for music and woodworking, Saiya Guitars has grown into a globally recognized brand synonymous with quality, resonance, and playability.</p>
                    
                    <h3>Our Heritage</h3>
                    <p>Rooted in the rich cultural heritage of Indonesia, our master luthiers combine traditional woodworking techniques with modern acoustic engineering. From hand-selecting the finest tonewoods to the final polishing stage, every Saiya Guitar is a masterpiece of dedication.</p>
                    
                    <h3>Our Commitment to Musicians</h3>
                    <p>Whether you are strumming your first chords on an acoustic, shredding solos on an electric, or exploring the tropical vibes of a ukulele, Saiya Guitars is committed to providing instruments that inspire. Our rigorous quality control ensures that when you hold a Saiya, you hold perfection.</p>
                ',
                'image' => '/storage/images/factory.webp',
                'status' => 'publish',
                'type' => 'post',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'The Art of Tonewoods: Why Materials Matter in Saiya Guitars',
                'slug' => 'the-art-of-tonewoods',
                'excerpt' => 'An inside look at how PT SAIYA INDONESIA selects premium woods like Ebony, Mahogany, and Rosewood for superior sound.',
                'content' => '
                    <p>The secret to the unmistakable sound of a <strong>Saiya Guitar</strong> lies in the wood. At PT SAIYA INDONESIA, we source only the most resonant and visually stunning tonewoods from sustainable forests around the world.</p>
                    
                    <h3>Ebony: The Standard for Fingerboards</h3>
                    <p>For our high-end classical and electric models, we utilize dense, smooth Ebony for our fingerboards. Its incredibly tight grain provides a fast playing surface, sharp attack, and lasting durability against string wear.</p>

                    <h3>Mahogany and Maple</h3>
                    <p>For warm, balanced mid-ranges, Mahogany is our go-to for backs and necks. Meanwhile, our Maple tops provide the brilliant, snappy attack that makes our acoustic guitars sing across concert halls.</p>

                    <p>Experience the natural resonance yourself by testing out a Saiya Guitar today.</p>
                ',
                'image' => '/storage/images/acoustic.webp',
                'status' => 'publish',
                'type' => 'post',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Innovation Meets Tradition: The Saiya Electric Series',
                'slug' => 'innovation-meets-tradition-saiya-electric',
                'excerpt' => 'Explore the cutting-edge technology and classic designs merged into the new Saiya Electric Guitar lineup.',
                'content' => '
                    <p>PT SAIYA INDONESIA is proud to showcase our Electric Guitar series—where classic body contours meet modern electronic innovation. Designed for the versatile performer, these guitars are built to dominate any genre.</p>
                    
                    <h3>Versatile Tones</h3>
                    <p>Equipped with custom-wound pickups, our electric guitars offer everything from crystal-clear cleans to aggressive, high-gain roars. The solid body construction ensures infinite sustain and feedback resistance.</p>
                    
                    <h3>Precision Playability</h3>
                    <p>Every neck is carved to a comfortable modern profile and fitted with precision-leveled frets. The effortless playability allows guitarists to perform with absolute freedom and confidence on stage.</p>
                ',
                'image' => '/storage/images/electric.webp',
                'status' => 'publish',
                'type' => 'post',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        foreach ($posts as $post) {
            \App\Models\Post::updateOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}
