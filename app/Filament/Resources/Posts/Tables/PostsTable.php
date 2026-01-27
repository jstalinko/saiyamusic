<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->html()
                    ->label('Post')
                    ->formatStateUsing(function (string $state, $record): string {
                        $statusText = $record->status == 'publish' ? 'Published' : 'Draft';
                        $statusColor = $record->status == 'publish' ? 'green' : 'red';
                        $badgeHtml = '<span 
            style="
                background-color: ' . $statusColor . '; 
                color: white; 
                padding: 2px 8px; 
                border-radius: 9999px; 
                font-size: 0.75rem; 
                font-weight: 600;
                vertical-align: middle;
            "
        >' . $statusText . '</span>';
                        return '
            <div>
                <b style="font-size: 15px;word-wrap: break-word;">' . $state . '</b>
                <div style="font-size: 0.8rem; margin-top: 4px;">
                    @' . $record->author->name . ' - ' . $badgeHtml . '
                </div>
            </div>
        ';
                    }),
                TextColumn::make('labels')
                    ->html()
                    ->formatStateUsing(function ($state) {
                        if ($state['taxonomy'] == 'category') {
                            return '<b>' . $state['name'] . '</b>';
                        }
                        if ($state['taxonomy'] == 'tag') {
                            return '<span style="color: #6b7280;">' . $state['name'] . '</span>';
                        }
                    })->label('Categories & Tags')
                    ->sortable(),
                TextColumn::make('commentsCount')
                    ->label('Comments')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')->label('Post Type')->options([
                    'post' => 'Post',
                    'page' => 'Page',
                ]),
                SelectFilter::make('status')->label('Post Status')->options([
                    'publish' => 'Published',
                    'draft' => 'Draft',
                    'pending' => 'Pending',
                ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('Publish')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => 'publish',
                                ]);
                            }
                        })->deselectRecordsAfterCompletion()->requiresConfirmation(),
                    BulkAction::make('Draft')
                        ->icon('heroicon-o-x-mark')
                        ->color('warning')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => 'draft',
                                ]);
                            }
                        })->deselectRecordsAfterCompletion()->requiresConfirmation(),
                ]),
            ]);
    }
}
