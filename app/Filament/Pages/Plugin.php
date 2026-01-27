<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;
use Filament\Notifications\Notification;
use UnitEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\File;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class Plugin extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?int $navigationSort = 7;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::PuzzlePiece;
    protected static string|UnitEnum|null $navigationGroup = 'Customize';
    protected static ?string $navigationLabel = 'Plugins';

    protected string $view = 'filament.pages.plugin';

    public array $plugins = [];

    public function mount(): void
    {
        $pluginDirectories = File::directories(base_path('plugins'));
        $pluginsData = [];

        foreach ($pluginDirectories as $dir) {
            $pluginName = basename($dir);
            $jsonPath = $dir . '/plugin.json';

            if (File::exists($jsonPath)) {
                $config = json_decode(File::get($jsonPath), true);

                $isActive = isset($config['active']) && $config['active'] === true;

                $pluginsData[] = [
                    'directory_name' => $pluginName,
                    'plugin_name' => $config['plugin_name'] ?? 'N/A',
                    'plugin_desc' => $config['plugin_desc'] ?? 'N/A',
                    'version' => $config['version'] ?? 'N/A',
                    'author_name' => $config['author_name'] ?? 'N/A',
                    'status' => $isActive ? 'enabled' : 'disabled',
                    'json_path' => $jsonPath,
                ];
            }
        }

        $this->plugins = $pluginsData;
    }

    protected function getTableQuery(): ?Builder
    {
        return null;
    }

    protected function getTableData(): array
    {
        return $this->plugins;
    }

    protected function table(Table $table): Table
    {
        return $table
            ->records(fn() => $this->plugins)
            ->columns([
                TextColumn::make('plugin_name')
                    ->label('Plugin Name'),

                TextColumn::make('plugin_desc')
                    ->label('Description'),

                TextColumn::make('author_name')
                    ->label('Author'),

                TextColumn::make('version')
                    ->label('Version')
                    ->badge(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'enabled' => 'success',
                        'disabled' => 'danger',
                        default => 'warning',
                    }),
            ])
            ->recordActions([
                Action::make('toggle_status')
                    ->label(fn(array $record) => $record['status'] === 'enabled' ? 'Disable' : 'Enable')
                    ->color(fn(array $record) => $record['status'] === 'enabled' ? 'danger' : 'success')
                    ->icon(
                        fn(array $record) => $record['status'] === 'enabled'
                            ? 'heroicon-o-x-circle'
                            : 'heroicon-o-check-circle'
                    )
                    ->requiresConfirmation()
                    ->action(fn(array $record) => $this->togglePluginStatus($record)),
            ]);
    }

    public function togglePluginStatus(array $record): void
    {
        $jsonPath = $record['json_path'];

        if (!File::exists($jsonPath)) {
            Notification::make()
                ->danger()
                ->title("plugin.json tidak ditemukan!")
                ->send();
            return;
        }

        $config = json_decode(File::get($jsonPath), true);

        $current = $config['active'] ?? false;
        $newStatus = !$current;

        $config['active'] = $newStatus;

        File::put($jsonPath, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        Notification::make()
            ->success()
            ->title("Plugin **{$record['plugin_name']}** " . ($newStatus ? "Enabled" : "Disabled") . "!")
            ->send();
        $this->redirect(route('filament.admin.pages.plugin'));
    }
}
