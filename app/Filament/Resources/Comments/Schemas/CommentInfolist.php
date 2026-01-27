<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CommentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('post_id')
                    ->numeric(),
                TextEntry::make('user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('parent_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('author_name')
                    ->placeholder('-'),
                TextEntry::make('author_email')
                    ->placeholder('-'),
                TextEntry::make('author_ip')
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
