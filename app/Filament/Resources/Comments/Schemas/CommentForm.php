<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('post_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('parent_id')
                    ->numeric(),
                Textarea::make('content')
                    ->columnSpanFull(),
                TextInput::make('author_name'),
                TextInput::make('author_email')
                    ->email(),
                TextInput::make('author_ip'),
                TextInput::make('status')
                    ->required()
                    ->default('approved'),
            ]);
    }
}
