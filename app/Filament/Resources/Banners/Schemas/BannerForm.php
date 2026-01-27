<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('title')
                    ->required(),
                TextInput::make('subtitle')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->image()
                    ->required(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
