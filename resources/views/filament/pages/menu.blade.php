<x-filament::page>
    <style>
        /* Container wrapper (gunakan id agar selektor spesifik) */
        #jadicms-menu {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            color: #e6eef8;
        }

        /* Header */
        #jadicms-menu .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        #jadicms-menu h2 {
            margin: 0;
            font-size: 20px;
            color: #ffffff;
            font-weight: 700;
        }

        /* Filament buttons inside panel (generic) */
        #jadicms-menu button,
        #jadicms-menu .filament-button {
            background: #f97316;
            /* orange */
            color: #081222;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
        }

        #jadicms-menu button[aria-pressed="true"],
        #jadicms-menu .filament-button--active {
            transform: translateY(0);
        }

        /* Sections */
        #jadicms-menu .section {
            background: #0b1116;
            /* dark panel */
            border: 1px solid rgba(255, 255, 255, 0.04);
            padding: 14px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(2, 6, 8, 0.6);
        }

        /* Headings inside section */
        #jadicms-menu .section h3,
        #jadicms-menu .section .section-heading {
            margin: 0 0 8px 0;
            color: #cfe7ff;
            font-size: 14px;
            font-weight: 700;
        }

        /* Sortable list */
        #jadicms-menu #sortable {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        #jadicms-menu #sortable li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 14px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.03);
            color: #e6eef8;
            transition: box-shadow .12s ease, transform .08s ease;
            cursor: grab;
        }

        #jadicms-menu #sortable li:active {
            cursor: grabbing;
            transform: scale(.998);
        }

        #jadicms-menu #sortable li .meta {
            color: #9fb6d6;
            font-size: 12px;
        }

        /* Drag ghost */
        .ghost {
            opacity: 0.5 !important;
        }

        /* Table editor */
        #jadicms-menu table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            table-layout: fixed;
        }

        #jadicms-menu thead th {
            text-align: left;
            padding: 12px 10px;
            color: #b7d7ff;
            font-weight: 700;
            font-size: 13px;
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        #jadicms-menu tbody tr {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.01), rgba(255, 255, 255, 0.0));
            border-radius: 10px;
            box-shadow: 0 6px 14px rgba(2, 6, 8, 0.55);
        }

        #jadicms-menu tbody td {
            padding: 10px;
            vertical-align: middle;
        }

        /* Inputs/selects */
        #jadicms-menu input[type="text"],
        #jadicms-menu select {
            width: 100%;
            padding: 8px 10px;
            background: #061018;
            border: 1px solid rgba(255, 255, 255, 0.04);
            color: #e6eef8;
            border-radius: 8px;
            outline: none;
            font-size: 13px;
        }

        #jadicms-menu input[type="text"]::placeholder {
            color: rgba(230, 238, 248, 0.3);
        }

        #jadicms-menu input[type="text"]:focus,
        #jadicms-menu select:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
            border-color: rgba(59, 130, 246, 0.9);
        }

        /* Checkbox */
        #jadicms-menu input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #3b82f6;
            /* blue accent */
            border-radius: 4px;
        }

        /* Delete button */
        #jadicms-menu .btn-delete {
            background: #ef4444;
            color: white;
            padding: 6px 10px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }

        #jadicms-menu .btn-delete:hover {
            background: #dc2626;
        }

        /* Save button (right bottom) */
        #jadicms-menu .btn-save {
            background: #16a34a;
            color: #042018;
            padding: 10px 14px;
            border-radius: 9px;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }

        /* Responsive tweaks */
        @media (max-width: 860px) {
            #jadicms-menu .section {
                padding: 12px;
            }

            #jadicms-menu #sortable li {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            #jadicms-menu thead {
                display: none;
            }

            #jadicms-menu tbody td {
                display: block;
                padding: 8px 6px;
            }

            #jadicms-menu tbody tr {
                margin-bottom: 8px;
                display: block;
            }
        }
    </style>


    <div class="space-y-8" id="jadicms-menu">

        <!-- HEADER + ADD BUTTON -->
        <div class="flex justify-between items-center">
            <x-filament::button wire:click="addMenu" icon="heroicon-o-plus" color="primary" class="rounded-lg">
                Add Menu
            </x-filament::button>
            <br><br>
        </div>

        <!-- SORTER SECTION -->
        <x-filament::section heading="Menu Sorter" collapsible>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Drag & drop untuk mengurutkan menu utama. Submenu mengikuti parent-nya otomatis.
            </p>

            <ul id="sortable" class="space-y-3">

                @foreach ($menus as $menu)
                    <li wire:key="menu-sort-{{ $menu['id'] }}" data-id="{{ $menu['id'] }}"
                        class="flex items-center justify-between bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm px-4 py-3 transition-all cursor-move hover:shadow-md">

                        <div>
                            <div class="font-semibold text-gray-800 dark:text-gray-100">
                                {{ $menu['label'] }}
                            </div>

                            <div class="text-xs mt-1 text-gray-500 flex items-center gap-2">

                                {{-- URL TAG --}}
                                <span
                                    class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 border border-gray-300/60 text-gray-600 dark:text-gray-300 rounded text-[11px]">
                                    {{ $menu['url'] }}
                                </span>

                                {{-- CHILD TAG --}}
                                @if ($menu['parent_id'])
                                    <span
                                        class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 border border-blue-300/60 rounded text-[11px]">
                                        Child of: {{ $this->getParentMenus()[$menu['parent_id']] ?? '—' }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <x-filament::icon icon="heroicon-o-arrows-up-down" class="w-5 h-5 text-gray-400" />
                    </li>
                @endforeach

            </ul>
        </x-filament::section>
        <br>
        <!-- EDITOR SECTION -->
        <x-filament::section heading="Menu Editor" collapsible>

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Edit label, URL, parent, dan tipe menu (parent/submenu).
            </p>

            <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">

                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700/60">
                        <tr>
                            <th class="p-3 text-left font-medium text-gray-700 dark:text-gray-200">Label</th>
                            <th class="p-3 text-left font-medium text-gray-700 dark:text-gray-200">URL</th>
                            <th class="p-3 text-left font-medium text-gray-700 dark:text-gray-200">Parent</th>
                            <th class="p-3 text-center font-medium text-gray-700 dark:text-gray-200">Is Parent?</th>
                            <th class="p-3 text-right font-medium w-24"></th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">

                        @foreach ($menus as $i => $m)
                            <tr wire:key="menu-edit-{{ $m['id'] }}">

                                <!-- LABEL -->
                                <td class="p-3">
                                    <x-filament::input wire:model.defer="menus.{{ $i }}.label"
                                        placeholder="Menu label" class="w-full rounded-lg" />
                                </td>

                                <!-- URL -->
                                <td class="p-3">
                                    <x-filament::input wire:model.defer="menus.{{ $i }}.url"
                                        placeholder="/your-url" class="w-full rounded-lg" />
                                </td>

                                <!-- PARENT SELECT -->
                                <td class="p-3">
                                    <select wire:model.defer="menus.{{ $i }}.parent_id"
                                        class="w-full border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm rounded-lg p-2">
                                        <option value="">— None —</option>

                                        @foreach ($this->getParentMenus() as $pid => $plabel)
                                            @if ($pid !== $m['id'])
                                                <option value="{{ $pid }}">{{ $plabel }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>

                                <!-- IS PARENT CHECKBOX -->
                                <td class="p-3 text-center">
                                    <input type="checkbox" wire:model.defer="menus.{{ $i }}.is_parent"
                                        class="h-4 w-4 text-primary-600 dark:text-primary-400 rounded border-gray-300 dark:border-gray-600 focus:ring-primary-500">
                                </td>

                                <!-- DELETE BUTTON -->
                                <td class="p-3 text-right">
                                    <x-filament::button wire:click="remove('{{ $m['id'] }}')"
                                        icon="heroicon-o-trash" color="danger" size="sm" class="rounded-lg">
                                        Delete
                                    </x-filament::button>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>

        </x-filament::section>
        <br>
        <!-- SAVE BUTTON -->
        <div class="flex justify-end pt-2">
            <x-filament::button type="submit" color="success" wire:click="save" icon="heroicon-o-check-circle"
                class="rounded-lg px-6 py-2">
                Save Menus
            </x-filament::button>
        </div>

    </div>


    <!-- SORTABLE JS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        function initSortable() {
            const el = document.getElementById('sortable');
            if (!el) return;

            if (el.sortable) el.sortable.destroy();

            el.sortable = new Sortable(el, {
                animation: 160,
                ghostClass: 'opacity-40',
                handle: '.cursor-move',
                onEnd() {
                    const ids = [...el.children].map(li => li.dataset.id);
                    Livewire.dispatch('reorderMenus', {
                        ids
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', initSortable);
        document.addEventListener('livewire:navigated', initSortable);
    </script>

</x-filament::page>
