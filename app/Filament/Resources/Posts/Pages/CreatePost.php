<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (Post::where('slug', Str::slug($data['title']))->exists()) {
            $slug = Str::slug($data['title']);
            $data['slug'] = $slug . '-' . bin2hex(time());
        }
        $data['user_id'] = Auth::user()->id;
        $data['excerpt'] = Str::limit($data['content'], 160);
        return $data;
    }
    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        $formData = $this->data;

        $tagIds = [];

        if (!empty($formData['tags']) && is_array($formData['tags'])) {
            foreach ($formData['tags'] as $tagName) {
                $tag = Label::firstOrCreate(
                    [
                        'name' => trim($tagName),
                        'taxonomy' => 'tag'
                    ],
                    [
                        'slug' => Str::slug($tagName),
                    ]
                );

                $tagIds[] = $tag->id;
            }
        }

        $categoryIds = [];

        if (!empty($formData['category'])) {
            $categoryIds[] = $formData['category'];
        }
        $categoryIds = [];

        if (!empty($formData['category'])) {
            $categoryIds[] = $formData['category'];
        }


        $allLabelIds = array_merge($categoryIds, $tagIds);

        $record->labels()->sync($allLabelIds);
    }
}
