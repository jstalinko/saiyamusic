<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('filename')
                    ->required(),
                TextInput::make('path')
                    ->required(),
                TextInput::make('mime')
                    ->required(),
                TextInput::make('size')
                    ->numeric(),
                TextInput::make('user_id')
                    ->numeric(),
            ]);
    }
}
