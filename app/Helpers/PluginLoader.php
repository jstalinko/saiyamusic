<?php

namespace App\Helpers;

class PluginLoader
{
    public static function all(): array
    {
        $plugins = [];

        foreach (glob(base_path('plugins/*/plugin.json')) as $json) {
            $config = json_decode(file_get_contents($json), true);

            $plugins[] = [
                'path' => dirname($json),
                'config' => $config,
            ];
        }

        return $plugins;
    }

    public static function active(): array
    {
        $providers = [];

        foreach (self::all() as $plugin) {

            $config = $plugin['config'];

            // STATUS by plugin.json
            $isActive = isset($config['active']) && $config['active'] === true;

            if ($isActive) {
                // Load semua provider plugin
                foreach ($config['providers'] ?? [] as $provider) {
                    $providers[] = $provider;
                }
            }
        }

        return $providers;
    }
}
