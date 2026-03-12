<?php
$baseDir = __DIR__ . '/../storage/app/public/images';
$categories = ['acoustic', 'bass', 'classic', 'electric', 'ukulele'];

echo "<html><body style='font-family: sans-serif; background: #fff;'>";
echo "<h1>Guitar Images Gallery</h1>";
echo "<p>Please identify the front-facing guitar for each category.</p>";

$count = 1;
foreach ($categories as $cat) {
    if (!is_dir("$baseDir/$cat")) continue;
    
    // read products.json
    $jsonPath = "$baseDir/$cat/products.json";
    if (!file_exists($jsonPath)) continue;
    $data = json_decode(file_get_contents($jsonPath), true);
    
    if (isset($data[$cat])) {
        foreach ($data[$cat] as $subCatName => $models) {
            foreach ($models as $modelName => $images) {
                // Only do the first model
                echo "<div style='margin-bottom: 40px; border-bottom: 1px solid #ccc; padding-bottom: 20px;'>";
                echo "<h3>$count. Category: $cat | Subcat: $subCatName | Model: $modelName</h3>";
                echo "<div style='display: flex; gap: 20px; overflow-x: auto;'>";
                
                foreach ($images as $img) {
                    $src = "/storage/images/$cat/$subCatName/$modelName/$img";
                    echo "<div style='text-align: center;'>";
                    echo "<img src='$src' style='height: 300px; max-width: 200px; object-fit: contain; border: 1px solid #eee;' />";
                    echo "<br/><span style='font-size: 11px; color: #333;'>$img</span>";
                    echo "</div>";
                }
                echo "</div></div>";
                $count++;
                break; // only first model
            }
        }
    }
}
echo "</body></html>";
