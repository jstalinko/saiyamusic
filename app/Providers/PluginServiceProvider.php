<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\PluginLoader;

class PluginServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Load semua service provider plugin yang aktif
        foreach (PluginLoader::active() as $provider) {
            $this->app->register($provider);
        }
    }

    public function boot()
    {
        //
    }
}
