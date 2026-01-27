<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;
use UnitEnum;
use Filament\Support\Icons\Heroicon;
use Livewire\Attributes\On;

class Menu extends Page
{
    protected static ?string $navigationLabel = 'Menu';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Square2Stack;
    protected static ?int $navigationSort = 7;
    protected static string|UnitEnum|null $navigationGroup = 'Customize';
    protected string $view = 'filament.pages.menu';

    public ?array $menus = [];

    public function mount()
    {
        $this->menus = json_decode(j_get_option('menus', '[]'), true);
    }

    #[On('reorderMenus')]
    public function reorderMenus($ids)
    {
        $new = [];

        foreach ($ids as $id) {
            $item = collect($this->menus)->firstWhere('id', $id);
            if ($item) {
                $new[] = $item;
            }
        }

        $this->menus = array_values($new);
    }

    public function save()
    {
        j_set_option('menus', json_encode($this->menus));

        \Filament\Notifications\Notification::make()
            ->title('Menus updated!')
            ->success()
            ->send();
    }

    public function remove($id)
    {
        $this->menus = array_values(
            array_filter($this->menus, fn($m) => $m['id'] !== $id)
        );
    }

    public function addMenu()
    {
        $this->menus[] = [
            'id' => uniqid(),
            'label' => 'New Menu',
            'url' => '#',
            'sort' => count($this->menus) + 1,
            'parent_id' => null,
            'is_parent' => false,
        ];
    }

    public function getParentMenus()
    {
        return collect($this->menus)
            ->filter(fn($m) => $m['is_parent'] === true)
            ->pluck('label', 'id');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
}
