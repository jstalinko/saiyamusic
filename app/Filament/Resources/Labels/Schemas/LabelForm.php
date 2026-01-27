<?php

namespace App\Filament\Resources\Labels\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LabelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('taxonomy')
                    ->required()
                    ->options([
                        'category' => 'Category',
                        'tag' => 'Tag',
                    ]),
                Textarea::make('description')
                    ->columnSpanFull()
            ]);
    }
}
