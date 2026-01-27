<?php

namespace App\Filament\Pages;

use UnitEnum;
use BackedEnum;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class Setting extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationLabel = 'Setting';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;
    protected static ?int $navigationSort = 7;
    protected static string|UnitEnum|null $navigationGroup = 'Customize';

    protected string $view = 'filament.pages.setting';

    public ?array $data = [];

    public function mount(): void
    {
        $this->data = $this->loadSettings();

        if (isset($this->data['meta_tags']) && is_string($this->data['meta_tags'])) {
            $this->data['meta_tags'] = json_decode($this->data['meta_tags'] ?? '[]', true);
        }
    }
    public function loadSettings(): array
    {

        return [
            'base_url'         => j_get_option('base_url', url('/')),
            'site_name'        => j_get_option('site_name', env('APP_NAME')),
            'tagline'          => j_get_option('tagline'),
            'icon'             => [j_get_option('icon')],
            'meta_keywords'    => j_get_option('meta_keywords'),
            'meta_description' => j_get_option('meta_description'),
            'meta_tags'        => j_get_option('meta_tags', "[]"),
        ];
    }

    public function save(): void
    { // Ambil state form Filament
        $data = $this->form->getState();

        // Pastikan kunci meta_tags diubah ke JSON jika dia array
        if (isset($data['meta_tags']) && is_array($data['meta_tags'])) {
            $data['meta_tags'] = json_encode($data['meta_tags'], JSON_PRETTY_PRINT);
        }


        // Simpan menggunakan helper WP-like
        j_set_options($data);

        Notification::make()
            ->title('Settings saved!')
            ->success()
            ->send();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('General')
                    ->schema([
                        TextInput::make('base_url')->label('Base URL')->required(),
                        TextInput::make('site_name')->label('Site Name')->required(),
                        TextInput::make('tagline'),
                        FileUpload::make('icon')->label('Site Icon'),
                    ]),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_keywords')->label('Meta Keywords'),
                        TextInput::make('meta_description')->label('Meta Description'),

                        Repeater::make('meta_tags')
                            ->schema([
                                TextInput::make('meta_name')->label('Meta Name')->required(),
                                TextInput::make('meta_content')->label('Meta Content')->required(),
                            ])
                            ->columns(2),
                    ]),
            ])
            ->statePath('data');
    }
}
