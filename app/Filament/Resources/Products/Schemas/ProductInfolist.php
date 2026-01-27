<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('product_category_id')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('model'),
                TextEntry::make('specifications')
                    ->columnSpanFull(),
                ImageEntry::make('image'),
                TextEntry::make('gallery')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
