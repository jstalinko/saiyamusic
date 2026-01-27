<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->label('Main Image')
                    ->image()
                    ->imageEditor()

                    ->imageEditorEmptyFillColor('#FFFFFF')
                    ->disk('public')
                    ->visibility('public')
                    ->directory('products')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('Gallery Images')
                    ->default(null)
                    ->image()
                    ->imageEditor()

                    ->imageEditorEmptyFillColor('#FFFFFF')
                    ->panelLayout('grid')
                    ->disk('public')
                    ->visibility('public')
                    ->directory('products')
                    ->multiple()
                    ->maxFiles(5)
                    ->columnSpanFull(),

                Select::make('product_category_id')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('model')
                    ->required(),
                Toggle::make('active')
                    ->required()->default(true),
                Toggle::make('featured')->label('is Featured Products?')
                    ->required()->default(false),
                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),

                KeyValue::make('specifications')
                    ->required()
                    ->columnSpanFull(),

            ]);
    }
}
