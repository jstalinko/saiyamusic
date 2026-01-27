<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    private function recursiveGlob($path)
    {
        $return = [];
        // Menggunakan GLOB_BRACE opsional jika ingin filter ekstensi di sini
        $files = glob($path . "/*");

        if ($files === false) return [];

        foreach ($files as $file) {
            if (is_dir($file)) {
                // Gabungkan hasil rekursif ke array utama
                $return = array_merge($return, $this->recursiveGlob($file));
            } else {
                // Masukkan data ke dalam satu index yang sama
                $return[] = [
                    'fullpath' => $file,
                    'folder' => basename($path),
                    'filename' => basename($file),
                ];
            }
        }
        return $return;
    }
    public function run(): void
    {
        // Ambil category tipe (untuk product_category_id)
        // Kamu bisa ganti jadi material jika di project kamu product_category_id memang untuk bahan.
        $classicCategory  = ProductCategory::where('slug', 'classic-guitars')->first();
        $electricCategory = ProductCategory::where('slug', 'electric-guitars')->first();
        $ukuleleCategory = ProductCategory::where('slug', 'ukulele')->first();

        $CATEGORY = "ukulele";

        // classic
        $PATH = "/media/shn/mewmew/saiya/ukulele";
        $files = $this->recursiveGlob($PATH);


        $groupedFiles = [];
        foreach ($files as $file) {
            $groupedFiles[$file['folder']][] = "products/{$CATEGORY}/{$file['folder']}/{$file['filename']}";
        }

        $productData = [];


        // 2. Iterasi berdasarkan group folder (setiap folder = satu produk)
        foreach ($groupedFiles as $folderName => $allImages) {
            // Ambil gambar pertama sebagai thumbnail/cover
            $coverImage = $allImages[0];

            $productData[] = [
                'name'                => 'SAIYA UKULELE ' . $folderName,
                'slug'                => str()->slug('SAIYA UKULELE ' . $folderName),
                'model'               => $folderName,
                'specifications'      => json_encode([
                    'model' => $folderName,
                    'category' => $CATEGORY,
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
                ]),
                'image'               => $coverImage,
                'product_category_id' => $ukuleleCategory->id,
                'gallery'             => json_encode($allImages),
                'active'              => true,
                'featured'            => rand(0, 1) ? true : false,
                'description' => '
    <div class="product-description">
        <p>Experience the exceptional craftsmanship of <strong>SAIYA GUITARS ' . $folderName . '</strong>. 
        Each instrument is meticulously handcrafted to meet the highest standards of professional musicians worldwide.</p>
        
        <h3>Why Choose Saiya Guitars?</h3>
        <ul>
            <li><strong>Premium Tonewoods:</strong> Selected for superior resonance and lasting durability.</li>
            <li><strong>Global Quality:</strong> Renowned globally for consistent tonal clarity and rich harmonic overtones.</li>
            <li><strong>Luthier-Grade Precision:</strong> Each bridge and fret is perfectly leveled for effortless playability and intonation.</li>
        </ul>
        
        <p>Whether on stage or in the studio, this instrument delivers a versatile sound profile that captures the true essence of your performance.</p>
    </div>
',
                'created_at'          => now(),
                'updated_at'          => now(),
            ];
        }

        \App\Models\Product::insert($productData);
    }
}
