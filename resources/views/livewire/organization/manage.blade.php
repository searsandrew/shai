<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage :organization', ['organization' => $organization->name]) }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto shadow-xl">
        <div class="bg-white p-6 overflow-hidden sm:rounded-lg">
            <div class="flex flex-row gap-5 items-start">
                <form class="grid grid-cols-6 gap-2" wire:submit.prevent="createOrganization">
                    <div class="flex flex-col flex-initial col-span-6 sm:col-span-3">
                        <x-input-label for="organization.name" value="{{ __('Organization Name') }}" />
                        <x-text-input id="organization.name" type="text" wire:model="organization.name" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="flex flex-col flex-initial col-span-6 sm:col-span-3">
                        <x-input-label for="organization.tax_id" value="{{ __('Organization Tax ID') }}" />
                        <x-text-input id="organization.tax_id" type="text" wire:model="organization.tax_id" />
                        <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
                    </div>
                    <div class="flex flex-col flex-initial col-span-6 sm:col-span-3">
                        <x-input-label for="address.street" value="{{ __('Organization Address') }}" />
                        <x-text-input id="address.street" type="text" wire:model="address.street" required />
                        <x-input-error :messages="$errors->get('address.street')" class="mt-2" />
                    </div>
                    <div class="flex flex-col flex-initial col-span-6 sm:col-span-3">
                        <x-input-label for="address.unit" value="{{ __('Unit Number') }}" />
                        <x-text-input id="address.unit" type="text" wire:model="address.unit" />
                        <x-input-error :messages="$errors->get('address.unit')" class="mt-2" />
                    </div>
                    <div class="flex flex-col flex-initial col-span-6 sm:col-span-2">
                        <x-input-label for="address.city" value="{{ __('City') }}" />
                        <x-text-input id="address.city" type="text" wire:model="address.city" required />
                        <x-input-error :messages="$errors->get('address.city')" class="mt-2" />
                    </div>
                    <div class="flex flex-col flex-initial col-span-6 sm:col-span-2">
                        <x-input-label for="address.state" value="{{ __('State') }}" />
                        <x-text-input id="address.state" type="text" wire:model="address.state" required />
                        <x-input-error :messages="$errors->get('address.state')" class="mt-2" />
                    </div>
                    <div class="flex flex-col flex-initial col-span-6 sm:col-span-2">
                        <x-input-label for="address.zip" value="{{ __('Zip Code') }}" />
                        <x-text-input id="address.zip" type="text" wire:model="address.zip" required />
                        <x-input-error :messages="$errors->get('address.zip')" class="mt-2" />
                    </div>
                    <div>
                        <x-primary-button wire:loading.attr="disabled" wire:target="createOrganization" class="">
                            {{ __('Edit Organization') }}
                        </x-primary-button>
                    </div>
                </form>
                @if($inviteSuccess)
                    <div class="relative w-1/3 shrink-0 flex flex-col gap-2 border border-emerald-100 pt-1 px-3 pb-2 bg-emerald-50 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-1 right-1 w-6 h-6 text-emerald-300 hover:text-emerald-200 transition-colors duration-300 cursor-pointer" fill="currentColor" viewBox="0 0 512 512" wire:click="$toggle('inviteSuccess')">
                            <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/>
                        </svg>
                        <h3 class="text-lg text-emerald-600 lighter">{{ __('Invite Sent') }}</h3>
                        <p class="text-sm italic text-slate-800">{{ __('Please check for an email with the invite code. If no email arrives promptly, check your spam mailbox.') }}</p>
                    </div>
                @else
                    <form class="w-1/3 shrink-0 flex flex-col gap-2 border border-slate-100 p-3 bg-slate-50 rounded" wire:submit.prevent="sendInviteCode">
                        <h3 class="text-lg text-slate-600 lighter">{{ __('Send an Invite Code') }}</h3>
                        <p class="text-sm italic text-slate-800">{{ __('Invite someone to join :organization.', ['organization' => $organization->name]) }}</p>
                        <div class="mb-3">
                            <x-input-label for="invite" value="{{ __('Email Address') }}" />
                            <x-text-input id="invite" type="text" wire:model="invite" />
                            <x-input-error :messages="$errors->get('invite')" class="mt-2" />
                        </div>
                        <div>
                            <x-primary-button wire:loading.attr="disabled" wire:target="join" class="">
                                {{ __('Send Invite') }}
                            </x-primary-button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
