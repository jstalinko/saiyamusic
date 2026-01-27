<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\File;
use UnitEnum;
use Filament\Notifications\Notification;

class Theme extends Page
{
    protected static ?int $navigationSort = 6;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::PaintBrush;

    protected static string|UnitEnum|null $navigationGroup = 'Customize';

    protected static ?string $navigationLabel = 'Theme';

    protected string $view = 'filament.pages.theme';

    public array $themes = [];

    public ?string $activeTheme = null;

    public function mount()
    {
        $this->activeTheme = j_active_theme();

        $this->themes = $this->loadThemes();
    }

    public function deleteTheme(string $themeSlug)
    {
        $path = resource_path("js/Themes/{$themeSlug}");

        if (!File::exists($path)) {
            $this->notify('danger', "Theme not found!");
            return;
        }

        // Prevent deleting active theme
        if ($this->activeTheme === $themeSlug) {
            $this->notify('danger', "Can't delete active theme!");
            return;
        }

        File::deleteDirectory($path);

        $this->notify('success', "Theme '{$themeSlug}' deleted successfully.");

        $this->redirect(request()->header('Referer'));
    }
    protected function loadThemes(): array
    {
        $base = resource_path('js/Themes');

        if (!File::exists($base)) {
            return [];
        }

        $directories = File::directories($base);

        $themes = [];

        foreach ($directories as $dir) {
            $jsonPath = $dir . '/theme.json';

            if (!File::exists($jsonPath)) {
                continue;
            }

            $data = json_decode(File::get($jsonPath), true);

            $slug = basename($dir);

            $themes[] = [
                'slug' => $slug,
                'path' => $dir,
                'name' => $data['theme_name'] ?? $slug,
                'author' => $data['theme_author'] ?? '',
                'version' => $data['theme_version'] ?? '',
                'screenshot' => $data['theme_screenshot'] ?? '',
                'description' => $data['theme_description'] ?? '',
                'data' => $data,
            ];
        }

        return $themes;
    }

    public function activateTheme(string $theme)
    {
        // Simpan tema aktif (ubah ke storage/settings/table terserah kamu)
        j_set_option('active_theme', $theme);
        cache()->forget('active_theme');

        $this->activeTheme = $theme;

        Notification::make()
            ->title('Theme Activated')
            ->body("Theme '{$theme}' activated successfully.")
            ->success()
            ->send();



        // $this->redirect(request()->header('Referer'));
    }
}
