<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 gap-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
        @foreach($organization->campaigns as $campaign)
            <a class="transition bg-white border border-slate-200 rounded-lg shadow-sm group hover:shadow-lg hover:bg-orange-50 hover:border-orange-100 cursor-pointer" href="{{ route('campaign.show', $campaign->slug) }}">
                @if($campaign->active)
                    <div class="w-full shadow-inner bg-emerald-600 text-emerald-50 py-0.5 tracking-widest uppercase text-xs text-center rounded-t-lg group-hover:bg-rose-700 group-hover:text-rose-50 mb-1">
                        {{ __('Campaign Active') }}
                    </div>
                @endif
                <h3 @class([
                    'text-lg text-slate-700 group-hover:text-orange-700 leading-6 cursor-pointer px-3',
                    'pt-3' => !$campaign->active
                ])>{{ $campaign->name }}</h3>
                <small class="italic text-slate-500 group-hover:text-orange-500 cursor-pointer px-3">{{ $campaign->started_at->toFormattedDateString() }} - {{ $campaign->ended_at->toFormattedDateString() }}</small>
                <hr/>
                <span class="text-xs text-center px-3 pb-2">{{ __(':donations of :recipients gifts have been claimed', ['donations' => 0, 'recipients' => 0]) }}</span>
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
                    <x-text-input id="name" type="text" class="mt-1 block w-full" wire:model="campaign.name" />
                    <x-input-error :messages="$errors->get('campaign.name')" class="mt-2" />
                </div>
                <div class="mt-3 flex flex-col sm:flex-row">
                    <div class="input-group sm:mr-1 w-full">
                        <x-input-label for="started_at" :value="__('Starting Date')" />
                        <x-text-input id="started_at" type="text" class="mt-1 block w-full" wire:model="campaign.started_at" />
                        <x-input-error :messages="$errors->get('campaign.started_at')" class="mt-2" />
                    </div>
                    <div class="input-group sm:ml-1 w-full">
                        <x-input-label for="ended_at" :value="__('Ending Date')" />
                        <x-text-input id="ended_at" type="text" class="mt-1 block w-full" wire:model="campaign.ended_at" />
                        <x-input-error :messages="$errors->get('campaign.ended_at')" class="mt-2" />
                    </div>
                </div>
                <div class="mt-3 flex flex-col sm:flex-row items-center">
                    <div class="input-group w-full sm:mr-1">
                        <x-toggle-checkbox model-id="campaign.toggle_image">{{ __('Landing Page') }}</x-toggle-checkbox>
                        <x-input-error :messages="$errors->get('campaign.toggle_image')" class="mt-2" />
                    </div>
                    <div class="input-group w-full sm:mx-1">
                        <x-toggle-checkbox model-id="campaign.toggle_family">{{ __('Group by Family') }}</x-toggle-checkbox>
                        <x-input-error :messages="$errors->get('campaign.toggle_family')" class="mt-2" />
                    </div>
                    <div class="input-group w-full sm:ml-1">
                        <x-toggle-checkbox model-id="campaign.toggle_privacy">{{ __('Enchanced Privacy') }}</x-toggle-checkbox>
                        <x-input-error :messages="$errors->get('campaign.toggle_privacy')" class="mt-2" />
                    </div>
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
