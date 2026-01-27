<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ProductCategory;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Category berdasarkan bahan
        // $materialCategories = [
        //     [
        //         'name' => 'MEH',
        //         'image' => '/images/meh.png',
        //         'description' => '
        //     <p><strong>Meh Wood (Suar)</strong> is increasingly used as an exotic alternative for guitar backs and sides, offering a unique visual flair.</p>
        //     <ul>
        //         <li><strong>Pros:</strong> Excellent durability and stunning, wavy grain patterns that make every guitar unique; provides a warm, balanced acoustic tone.</li>
        //         <li><strong>Cons:</strong> Its heavy density can make the guitar slightly heavier than traditional mahogany models.</li>
        //     </ul>',
        //         'active' => true,
        //     ],
        //     [
        //         'name' => 'EBONI',
        //         'image' => '/images/ebony.png',
        //         'description' => '
        //     <p><strong>Ebony</strong> is the gold standard for high-end classical guitar fingerboards and bridges.</p>
        //     <ul>
        //         <li><strong>Pros:</strong> Extremely hard and smooth, providing a fast playing surface and excellent "attack"; highly resistant to wear from fingernails and strings.</li>
        //         <li><strong>Cons:</strong> Very sensitive to humidity changes which can lead to cracks if not properly maintained in a climate-controlled environment.</li>
        //     </ul>',
        //         'active' => true,
        //     ],
        //     [
        //         'name' => 'MINDY',
        //         'image' => '/images/mindy.png',
        //         'description' => '
        //     <p><strong>Mindy Wood</strong> is often used in mid-range classical guitars as an alternative to Ash or Oak for the body construction.</p>
        //     <ul>
        //         <li><strong>Pros:</strong> Features a beautiful straight grain that enhances the guitar\'s aesthetic; provides a bright, crisp sound with good projection.</li>
        //         <li><strong>Cons:</strong> Requires high-quality grain filler during the finishing process due to its porous nature to achieve a smooth "gloss" look.</li>
        //     </ul>',
        //         'active' => true,
        //     ],
        // ];

        // Category berdasarkan tipe gitar
        $typeCategories = [
            [
                'name' => 'Classic Guitars',
                'image' => '/images/classic.webp',
                'description' => '
            <p><strong>Classical Guitars</strong> feature nylon strings that produce a warm, mellow, and rich resonance.</p>
            <ul>
                <li><strong>Best for:</strong> Fingerstyle, classical compositions, and bossa nova.</li>
                <li><strong>Key Feature:</strong> Wider fretboard for precise finger placement and soft string tension for smooth playability.</li>
            </ul>',
                'active' => true,
            ],
            [
                'name' => 'Electric Guitars',
                'image' => '/images/electric.webp',
                'description' => '
            <p><strong>Electric Guitars</strong> rely on electronic pickups to convert string vibrations into powerful, versatile sounds.</p>
            <ul>
                <li><strong>Best for:</strong> Rock, Jazz, Blues, and Metal styles.</li>
                <li><strong>Key Feature:</strong> Solid body design with high sustain and the ability to be shaped by various effects and amplifiers.</li>
            </ul>',
                'active' => true,
            ],
            [
                'name' => 'Ukulele',
                'image' => '/images/ukulele.webp',
                'description' => '
            <p><strong>Ukulele</strong> is a compact, four-stringed instrument that delivers a bright, cheerful, and percussive tone.</p>
            <ul>
                <li><strong>Best for:</strong> Tropical music, acoustic covers, and beginners due to its portable size.</li>
                <li><strong>Key Feature:</strong> Uses G-C-E-A tuning with nylon strings, making it very easy on the fingers for new players.</li>
            </ul>',
                'active' => true,
            ],
        ];

        $all = $typeCategories;

        foreach ($all as $cat) {
            ProductCategory::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'image' => $cat['image'],
                    'description' => $cat['description'],
                    'active' => $cat['active'],
                ]
            );
        }
    }
}
