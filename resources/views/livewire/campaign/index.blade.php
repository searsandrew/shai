<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 gap-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
        @foreach($organization->campaigns as $campaign)
            <a class="flex flex-col content-between transition bg-white border border-slate-200 rounded-lg shadow-sm group hover:shadow-lg hover:bg-orange-50 hover:border-orange-100 cursor-pointer" href="{{ route('campaign.show', $campaign->slug) }}">
                @if($campaign->active)
                    <div class="w-full shadow-inner bg-emerald-600 text-emerald-50 py-0.5 tracking-widest uppercase text-xs text-center rounded-t-lg group-hover:bg-rose-700 group-hover:text-rose-50 mb-1">
                        {{ __('Campaign Active') }}
                    </div>
                @endif
                <h3 @class([
                    'text-lg text-slate-700 group-hover:text-orange-700 leading-6 cursor-pointer px-3',
                    'pt-3' => !$campaign->active
                ])>{{ $campaign->name }}</h3>
                <small class="italic text-slate-500 group-hover:text-orange-500 cursor-pointer px-3 py-1">{{ $campaign->started_at->toFormattedDateString() }} - {{ $campaign->ended_at->toFormattedDateString() }}</small>
                <hr/>
                <span class="text-xs leading-3 text-center px-3 py-2 self-end">{{ __(':donations of :recipients gifts have been claimed', ['donations' => $campaign->recipients()->has('donors')->count(), 'recipients' => $campaign->recipients->count()]) }}</span>
            </a>
        @endforeach
        <x-secondary-button
            class="transition bg-slate-100 text-center border-dashed border-slate-200 rounded-lg shadow-inner p-3 group hover:bg-orange-50 hover:border-orange-100"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'create-new-campaign')" >
            <h3 class="text-lg font-extralight normal-case text-slate-500 group-hover:text-orange-700">{{ __('Start a new Campaign') }}</h3>    
        </x-secondary-button>

        <x-modal name="create-new-campaign" :show="$modal" maxWidth="lg" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Create a Campaign') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('To get started, enter a name and the starting and ending date. Additional details will be added once the campaign is created.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="name" :value="__('Campaign Name')" />
                    <x-text-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="campaign.name" />
                    <x-input-error :messages="$errors->get('campaign.name')" class="mt-2" />
                </div>
                <div class="mt-3 flex flex-col sm:flex-row">
                    <div class="input-group sm:mr-1 w-full">
                        <x-input-label for="started_at" :value="__('Starting Date')" />
                        <x-text-input id="started_at" type="date" class="mt-1 block w-full" wire:model.defer="campaign.started_at" />
                        <x-input-error :messages="$errors->get('campaign.started_at')" class="mt-2" />
                    </div>
                    <div class="input-group sm:ml-1 w-full">
                        <x-input-label for="ended_at" :value="__('Ending Date')" />
                        <x-text-input id="ended_at" type="date" class="mt-1 block w-full" wire:model.defer="campaign.ended_at" />
                        <x-input-error :messages="$errors->get('campaign.ended_at')" class="mt-2" />
                    </div>
                </div>
                <div class="mt-3 flex flex-col sm:flex-row justify-between items-center">
                    <span class="flex flex-row items-center">
                        @if($toggleImage)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1 text-orange-600 hover:text-orange-400 transition-all cursor-pointer" fill="currentColor" viewBox="0 0 576 512" wire:click="toggle('image', false)">
                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1 text-slate-300 hover:text-orange-500 transition-all cursor-pointer" fill="currentColor" viewBox="0 0 576 512" wire:click="toggle('image', true)">
                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/>
                            </svg>
                        @endif
                        <small>{{ __('Landing Page') }}</small>
                    </span>

                    <span class="flex flex-row items-center">
                        @if($toggleGroup)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1 text-orange-600 hover:text-orange-400 transition-all cursor-pointer" fill="currentColor" viewBox="0 0 576 512" wire:click="toggle('group', false)">
                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1 text-slate-300 hover:text-orange-500 transition-all cursor-pointer" fill="currentColor" viewBox="0 0 576 512" wire:click="toggle('group', true)">
                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/>
                            </svg>
                        @endif
                        <small>{{ __('Select by Group') }}</small>
                    </span>

                    <span class="flex flex-row items-center">
                        @if($togglePrivacy)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1 text-orange-600 hover:text-orange-400 transition-all cursor-pointer" fill="currentColor" viewBox="0 0 576 512" wire:click="toggle('privacy', true)">
                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1 text-slate-300 hover:text-orange-500 transition-all cursor-pointer" fill="currentColor" viewBox="0 0 576 512" wire:click="toggle('privacy', true)">
                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/>
                            </svg>
                        @endif
                        <small>{{ __('Enhanced Privacy') }}</small>
                    </span>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ml-3" wire:click="createCampaign()" x-on:click="$dispatch('close')">
                        {{ __('Create Campaign') }}
                    </x-primary-button>
                </div>
            </div>
        </x-modal>
    </div>
</div>
