<?php

namespace App\Filament\Resources\Labels\Pages;

use App\Filament\Resources\Labels\LabelResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use App\Models\Label;

class CreateLabel extends CreateRecord
{
    protected static string $resource = LabelResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $slug = Str::slug($data['name']);
        if (Label::where('slug', $slug)->exists()) {
            $slug = Str::slug($data['name']) . '-' . bin2hex(time());
        }

        $data['slug'] = $slug;
        return $data;
    }
}
