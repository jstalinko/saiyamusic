<?php

namespace App\Filament\Resources\ProductCategories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('categories')
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('active')
                    ->required()->default(true),
            ]);
    }
}
