<x-filament::page>
    <div class="theme-grid">

        @foreach ($themes as $theme)
        <x-filament::card class="theme-card">

            {{-- Screenshot --}}
            <img
                src="{{ $theme['screenshot'] }}"
                alt="{{ $theme['name'] }}">

            <div class="p-3 theme-body">
                <h3 class="text-xl font-semibold" style="padding:10px">
                    {{ strtoupper($theme['name']) }}
                </h3>
                <hr>
                <p class="text-sm text-gray-600 dark:text-gray-400" style="margin-top:10px">
                    {{ $theme['description'] }}
                </p>

                <p class="text-xs text-gray-500 dark:text-gray-400 pt-2">
                    <strong>Author:</strong> {{ $theme['author'] }} <br>
                    <strong>Version:</strong> {{ $theme['version'] }}
                </p>
            </div>

            <div class="p-3 theme-footer flex items-center gap-3">
                @if ($activeTheme === $theme['slug'])
                <x-filament::badge color="success">
                    Active
                </x-filament::badge>
                @else
                <x-filament::button color="primary" size="sm" wire:click="activateTheme('{{ $theme['slug'] }}')">
                    Activate
                </x-filament::button>
                @endif

                @if ($activeTheme !== $theme['slug'])
                <x-filament::button color="danger" size="sm" wire:click="deleteTheme('{{ $theme['slug'] }}')">
                    Delete
                </x-filament::button>
                @endif
            </div>

        </x-filament::card>
        @endforeach

    </div>

    <style>
        .theme-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
            align-items: stretch;
        }

        .theme-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            border-radius: 12px;
            overflow: hidden;
        }

        .theme-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .theme-body {
            flex: 1;
        }

        .theme-footer {
            margin-top: auto;
        }
    </style>

</x-filament::page>