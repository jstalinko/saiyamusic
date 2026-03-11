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
            'bass' => 'bass',
            'classic-guitars' => 'classic',
            'electric-guitars' => 'electric',
            'ukulele' => 'ukulele',
        ];

        foreach ($categoryPath as $slug => $folderName) {
            $jsonFile = public_path("images/{$folderName}/products.json");

            if (!\Illuminate\Support\Facades\File::exists($jsonFile)) {
                continue;
            }

            $jsonData = json_decode(\Illuminate\Support\Facades\File::get($jsonFile), true);
            if (!$jsonData || !isset($jsonData[$folderName])) {
                continue;
            }

            $category = \App\Models\ProductCategory::where('slug', $slug)->first();
            if (!$category) {
                continue;
            }

            $categoryName = $category->name;

            foreach ($jsonData[$folderName] as $subCategoryKey => $models) {
                // Subcategory Name format: SAIYA ACOUSTIC 360G
                $subCategoryName = 'SAIYA ' . strtoupper($categoryName) . ' ' . strtoupper($subCategoryKey);
                $subCategorySlug = str()->slug($subCategoryName);

                // Get first available image for subcategory coverage
                $fallbackImage = '';
                foreach ($models as $modelKey => $imgs) {
                    if (!empty($imgs)) {
                        $imgDir = (strtoupper($subCategoryKey) === strtoupper($modelKey))
                            ? "{$subCategoryKey}"
                            : "{$subCategoryKey}/{$modelKey}";
                        $fallbackImage = "/images/{$folderName}/{$imgDir}/{$imgs[0]}";
                        break;
                    }
                }

                $subcategory = \App\Models\ProductSubCategory::firstOrCreate(
                    ['slug' => $subCategorySlug],
                    [
                        'product_category_id' => $category->id,
                        'name' => $subCategoryName,
                        'image' => $fallbackImage,
                    ]
                );

                foreach ($models as $modelKey => $images) {
                    if (empty($images)) {
                        continue;
                    }

                    // Product Name format: SAIYA ACOUSTIC 360G SF-360G
                    // If subcategory and model are the same, don't duplicate it.
                    if (strtoupper($subCategoryKey) === strtoupper($modelKey)) {
                        $productName = $subCategoryName;
                    } else {
                        $productName = $subCategoryName . ' ' . strtoupper($modelKey);
                    }
                    $productSlug = str()->slug($productName);

                    $imagePathDir = (strtoupper($subCategoryKey) === strtoupper($modelKey))
                        ? "/images/{$folderName}/{$subCategoryKey}/"
                        : "/images/{$folderName}/{$subCategoryKey}/{$modelKey}/";

                    $coverImage = $imagePathDir . $images[0];
                    $gallery = [];
                    foreach ($images as $img) {
                        $gallery[] = $imagePathDir . $img;
                    }

                    $insertProductData = [
                        'product_sub_category_id' => $subcategory->id,
                        'product_category_id' => $category->id,
                        'name' => $productName,
                        'model' => $modelKey,
                        'slug' => $productSlug,
                        'specifications' => [
                            'model' => $modelKey,
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
        <p>Experience the exceptional craftsmanship of <strong>SAIYA GUITARS ' . $modelKey . '</strong>. 
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
}