<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Label;
use Filament\Forms\Components\TagsInput;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('posts')
                    ->visibility('public')
                    ->columnSpanFull(),
                TextInput::make('title')
                    ->required()
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->columnSpanFull(),
                Select::make('status')
                    ->required()
                    ->options([
                        'publish' => 'Publish',
                        'draft' => 'Draft',
                    ])
                    ->default('publish'),
                Select::make('type')
                    ->required()
                    ->options([
                        'post' => 'Post',
                        'page' => 'Page',
                    ])
                    ->default('post'),
                Select::make('category')
                    ->required()
                    ->options(Label::getCategoryOnly()->pluck('name', 'id'))
                    ->default('post'),
                TagsInput::make('tags')
                    ->required()
                    ->default('post'),

            ]);
    }
}
