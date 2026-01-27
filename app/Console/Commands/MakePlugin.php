<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakePlugin extends Command
{
    protected $signature = 'make:plugin {name}';
    protected $description = 'Generate a JadiCMS plugin structure';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $pluginPath = base_path("plugins/$name");

        if (File::exists($pluginPath)) {
            $this->error("Plugin '$name' already exists!");
            return;
        }

        // ───────────────────────────────────────────────
        // FOLDER STRUCTURE (sesuai struktur plugin kamu)
        // ───────────────────────────────────────────────
        $directories = [
            "",
            "/src",
            "/src/Http/Controllers",
            "/src/Models",
            "/src/Filament",
            "/src/Inertia",
            "/src/Views",
            "/src/Database/Migrations",
            "/routes",
        ];

        foreach ($directories as $dir) {
            File::makeDirectory("$pluginPath$dir", 0755, true);
        }

        // ───────────────────────────────────────────────
        // FILES
        // ───────────────────────────────────────────────
        File::put("$pluginPath/routes/web.php", $this->webRoute($name));
        File::put("$pluginPath/routes/api.php", $this->apiRoute());

        File::put("$pluginPath/src/PluginServiceProvider.php", $this->provider($name));
        File::put("$pluginPath/src/Http/Controllers/{$name}Controller.php", $this->controller($name));
        File::put("$pluginPath/src/Models/$name.php", $this->model($name));
        File::put("$pluginPath/src/Filament/{$name}Resource.php", $this->filamentResource($name));
        File::put("$pluginPath/src/Inertia/Index.vue", $this->inertiaVue());
        File::put("$pluginPath/src/Views/app.blade.php", $this->viewFile());
        File::put("$pluginPath/src/Database/Migrations/.keep", "");

        File::put("$pluginPath/plugin.json", $this->pluginJson($name));

        $this->info("Plugin '$name' generated successfully!");
    }

    // ───────────────────────────────────────────────
    // GENERATORS
    // ───────────────────────────────────────────────

    private function pluginJson($name)
    {
        $providers = [
            "Plugins\\$name\\src\\PluginServiceProvider"
        ];

        return json_encode([
            "plugin_name" => $name,
            "plugin_desc" => "Description of $name plugin",
            "version" => "1.0.0",
            "author" => "jadicms",
            "providers" => $providers
        ], JSON_PRETTY_PRINT);
    }

    private function provider($name)
    {
        return <<<PHP
<?php

namespace Plugins\\$name\\src;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PluginServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Views
        \$this->loadViewsFrom(__DIR__ . '/Views', '$name');

        // Web routes
        if (file_exists(base_path("plugins/$name/routes/web.php"))) {
            Route::middleware('web')
                ->group(base_path("plugins/$name/routes/web.php"));
        }

        // API routes
        if (file_exists(base_path("plugins/$name/routes/api.php"))) {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path("plugins/$name/routes/api.php"));
        }

        // Migrations
        if (is_dir(__DIR__ . '/Database/Migrations')) {
            \$this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        }
    }
}
PHP;
    }

    private function webRoute($name)
    {
        return <<<PHP
<?php

use Illuminate\Support\Facades\Route;
use Plugins\\$name\\src\\Http\\Controllers\\{$name}Controller;

Route::get('/plugin-$name', [{$name}Controller::class, 'index']);

PHP;
    }

    private function apiRoute()
    {
        return <<<PHP
<?php

use Illuminate\Support\Facades\Route;

Route::get('/plugin-test', fn() => ['plugin' => 'ok']);

PHP;
    }

    private function controller($name)
    {
        return <<<PHP
<?php

namespace Plugins\\$name\\src\\Http\\Controllers;

use App\Http\Controllers\Controller;

class {$name}Controller extends Controller
{
    public function index()
    {
        return view('$name::app');
    }
}

PHP;
    }

    private function model($name)
    {
        return <<<PHP
<?php

namespace Plugins\\$name\\src\\Models;

use Illuminate\Database\Eloquent\Model;

class $name extends Model
{
    protected \$fillable = ['title'];

    protected \$table = strtolower('$name');
}

PHP;
    }

    private function filamentResource($name)
    {
        return <<<PHP
<?php

namespace Plugins\\$name\\src\\Filament;

use Filament\\Resources\\Resource;
use Filament\\Resources\\Pages\\ListRecords;
use Plugins\\$name\\src\\Models\\$name as {$name}Model;

class {$name}Resource extends Resource
{
    protected static ?string \$model = {$name}Model::class;

    public static function getPages(): array
    {
        return [
            'index' => ListRecords::route('/'),
        ];
    }
}

PHP;
    }

    private function inertiaVue()
    {
        return <<<VUE
<template>
    <div class="p-8">
        <h1 class="text-3xl font-bold">Plugin Loaded via Inertia + Vue</h1>
    </div>
</template>

<script setup>
</script>
VUE;
    }

    private function viewFile()
    {
        return <<<BLADE
<h1>Hello from plugin view!</h1>
BLADE;
    }
}
