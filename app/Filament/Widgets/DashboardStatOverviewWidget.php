<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use App\Models\Media;
use App\Models\Comment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatOverviewWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users',User::count()),
            Stat::make('Posts',Post::count()),
            Stat::make('Comments',Comment::count()),
            Stat::make('Medias',Media::count())
        ];
    }
}
