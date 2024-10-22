<div class="flex flex-col p-6 space-y-1.5">
    <h1 class="text-xl">{{ __('Manually Add Recipient') }}</h1>
    <div class="flex flex-row space-x-1.5">
        <span class="input-group flex flex-col w-3/4">
            <x-input-label for="recipientName">{{ __('Recipient Name') }}</x-input-label>
            <x-text-input type="text" wire:model="recipientName" class="w-full" />
        </span>
        <span class="input-group flex flex-col w-1/4">
            <x-input-label for="recipientName">{{ __('External ID') }}</x-input-label>
            <x-text-input type="text" wire:model="externalId" />
        </span>
    </div>
    <div class="input-group flex flex-col">
        <x-input-label for="recipientGroup">{{ __('Group') }}</x-input-label>
        <span class="flex flex-row space-x-1.5">
            <select wire:model="recipientGroup" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                @forelse($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @empty
                    <option disabled>{{ __('No Groups') }}</option>
                @endforelse
            </select>
            <x-secondary-button wire:click="addGroup" class="hover:text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-6" viewBox="0 0 640 512">
                    <!--!Font Awesome Pro 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc.-->
                    <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-13.4 0c-6.6-18.6-24.4-32-45.3-32l-32 0c-20.9 0-38.7 13.4-45.3 32l-77.4 0zm-26.7 32c19.3 0 37.6 4.1 54.2 11.5C422.5 372.3 416 385.4 416 400l0 8.6c-11.3-5.5-23.9-8.6-37.3-8.6l-117.3 0c-39.8 0-73.2 27.2-82.6 64l249.5 0c8.8 9.8 21.6 16 35.8 16l16 0 0 16c0 5.6 1 11 2.7 16l-328.1 0c-14.7 0-26.7-11.9-26.7-26.7C128 411.7 187.7 352 261.3 352l117.3 0zM320 272a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm0-144a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM512 336c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 48 48 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-48 0 0 48c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-48-48 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16l48 0 0-48z"/>
                </svg>
            </x-secondary-button>
        </span>
    </div>
    <div class="mt-6">
        <x-primary-button wire:click="addRecipient">{{ __('Add Recipient') }}</x-primary-button>
    </div>
</div>
