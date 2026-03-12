<?php

namespace App\Filament\Resources\ProductSubCategories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ProductSubCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Select::make('product_category_id')->relationship('category', 'name'),

            TextInput::make('name')
            ->required(),
            Textarea::make('description')
            ->default(null)
            ->columnSpanFull(),
            FileUpload::make('image')
            ->imageEditor()
            ->disk('public')
            ->visibility('public')
            ->image(),
            Toggle::make('active')
            ->required(),
        ]);
    }
}