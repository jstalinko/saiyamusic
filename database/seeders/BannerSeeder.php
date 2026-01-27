<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Saiya Guitars',
                'subtitle' => 'Crafted for Tone. Built for Expression.',
                'description' => 'Saiya Guitars designs and builds high-quality guitars with precision craftsmanship, carefully selected materials, and a strong tonal character. Every instrument is created to deliver exceptional sound, playability, and lasting performance for dedicated musicians.',
                'image' => '/images/banner/1.png'
            ],
            [
                'title' => 'Where Passion Becomes Sound',
                'subtitle' => 'Professional Guitars with No Compromise',
                'description' => 'As a guitar manufacturer, Saiya Guitars is committed to producing instruments that combine superior tone, refined design, and reliable construction. Our guitars are built to support musical creativity at every stage, from studio to stage.',
                'image' => '/images/banner/2.png'
            ],
            [
                'title' => 'Professional Guitars Built to Perform',
                'subtitle' => 'Designed for Sound. Crafted for Players.',
                'description' => 'Saiya Guitars creates professional-grade guitars engineered for clarity, sustain, and comfort. Built with precision craftsmanship and premium materials, our instruments are made to meet the demands of serious musicians on stage and in the studio.',
                'image' => '/images/banner/3.png'
            ]
        ];

        Banner::insert($data);
    }
}
