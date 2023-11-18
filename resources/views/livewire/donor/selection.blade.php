<div>
    <x-secondary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'donor-selections')"
        class="mr-3 cursor-pointer">
        {{ __(':count Selections', ['count' => $count]) }}
    </x-secondary-button>

    <x-modal name="donor-selections" :show="$modal" maxWidth="md" focusable>
        <h3 class="flex flex-row text-lg text-lighter items-center text-slate-700 px-3 pt-3">
            <span class="flex-1">{{ __('Selections') }}</span>
            <x-secondary-button class="px-0 py-0 border-none" x-on:click="$dispatch('close')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" height="1em" viewBox="0 0 384 512">
                    <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                </svg>
            </x-secondary-button>
        </h3>
        <div class="divide-y">
            <div class="mt-3 flex flex-col divide-y">
                @foreach($selections as $selection)
                    <div wire:key="selection-{{ $selection->id }}" class="flex flex-row w-full px-3 py-2">
                        <div class="w-1/4">{{ $selection->external_id }}</div>
                        <div class="grow">{{ $selection->name }}</div>
                        <div>
                            <x-secondary-button wire:click="remove('{{ $selection->id }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 512 512">
                                    <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/>
                                </svg>
                            </x-secondary-button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-modal>
</div>
