<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryPath = [
            'acoustic-guitars' => 'acoustic',
            'classic-guitars' => 'classic',
            'electric-guitars' => 'electric',
            'ukulele' => 'ukulele',
        ];

        foreach ($categoryPath as $slug => $folderName) {
            $category = \App\Models\ProductCategory::where('slug', $slug)->first();

            if (!$category) {
                continue;
            }

            $basePath = public_path("images/{$folderName}");

            if (!\Illuminate\Support\Facades\File::exists($basePath)) {
                continue;
            }

            $directories = \Illuminate\Support\Facades\File::directories($basePath);

            foreach ($directories as $dir) {
                $modelName = basename($dir); // folder name inside acoustic/classic etc

                // Get all .webp images (or any image)
                $files = collect(\Illuminate\Support\Facades\File::files($dir))
                    ->filter(function ($file) {
                    return in_array($file->getExtension(), ['webp', 'jpg', 'jpeg', 'png']);
                })->values();

                if ($files->isEmpty()) {
                    continue; // Skip if no images
                }

                $coverImage = "/images/{$folderName}/{$modelName}/" . $files->first()->getFilename();

                $gallery = $files->map(function ($file) use ($folderName, $modelName) {
                    return "/images/{$folderName}/{$modelName}/" . $file->getFilename();
                })->toArray();

                $categoryName = $category->name;

                $insertProductData = [
                    'product_category_id' => $category->id,
                    'name' => 'SAIYA ' . strtoupper($categoryName) . ' ' . strtoupper($modelName),
                    'model' => $modelName,
                    'slug' => str()->slug('saiya-' . $categoryName . ' ' . $modelName),
                    'specifications' => [
                        'model' => $modelName,
                        'category' => $categoryName,
                        'brand' => 'SAIYA',
                        'Size' => '480mm',
                        'Top' => 'Amara White Fiber Middle',
                        'Side/back' => 'Amara',
                        'Neck' => 'Meranti',
                        'Headneck' => 'Amara',
                        'Fretboard' => 'Amara 20 400R ABS Black',
                        'Spill' => '4.0',
                        'Nut-saddle' => '43-76MM Black',
                        'Sticker' => 'HX-1967',
                        'Logo' => 'LASER SAIYA',
                        'Label' => 'SAIYA',
                        'Colos' => 'NS Gloss',
                        'Tail handle' => 'Amara',
                        'ABS' => 'Ivory Front + 3 Rows',
                        'Head' => 'Amara #6',
                        'Bridge' => 'Amara #6',
                        'Bridge pins' => 'Black',
                        'Iron neck' => '440MM',
                        'Inner plate' => 'Meranti',
                        'Tuning pages' => 'JY-006 8.0',
                        'Strip pin' => '#1',
                        'String' => 'Acoustic BP-408',
                        'Pick guard' => '-',
                        'EQ' => '-',
                    ],
                    'image' => $coverImage,
                    'gallery' => $gallery,
                    'active' => true,
                    'featured' => rand(0, 1) ? true : false,
                    'description' => '<div class="product-description">
        <p>Experience the exceptional craftsmanship of <strong>SAIYA GUITARS ' . $modelName . '</strong>. 
        Each instrument is meticulously handcrafted to meet the highest standards of professional musicians worldwide.</p>
        
        <h3>Why Choose Saiya Guitars?</h3>
        <ul>
            <li><strong>Premium Tonewoods:</strong> Selected for superior resonance and lasting durability.</li>
            <li><strong>Global Quality:</strong> Renowned globally for consistent tonal clarity and rich harmonic overtones.</li>
            <li><strong>Luthier-Grade Precision:</strong> Each bridge and fret is perfectly leveled for effortless playability and intonation.</li>
        </ul>
        
        <p>Whether on stage or in the studio, this instrument delivers a versatile sound profile that captures the true essence of your performance.</p>
    </div>',
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                \App\Models\Product::updateOrCreate(
                ['slug' => $insertProductData['slug']],
                    $insertProductData
                );
            }
        }
    }
}