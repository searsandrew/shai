<div>
    <div class="py-12">
        <div class="max-w-4xl mx-auto shadow-xl">
            <img class="sm:rounded-t-lg" src="{{ asset('img/shai-banner-slim.png') }}" />
            <div class="bg-white p-6 overflow-hidden sm:rounded-b-lg">
                <h1 class="text-lg text-slate-600">{{ __('Welcome to :Name', ['name' => config('app.name')]) }}</h1>
                <div class="flex flex-row gap-5">
                    <form class="grid grid-cols-6 gap-2" wire:submit.prevent="createOrganization">
                        <p class="col-span-6">{{ __('To get started, please either setup a new organization or enter the invite code you were given to join an existing organization.') }}</p>
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
                                {{ __('Create Organization') }}
                            </x-primary-button>
                        </div>
                    </form>
                    <form class="w-1/3 shrink-0 flex flex-col gap-2 border border-orange-100 p-3 bg-orange-50 rounded" wire:submit.prevent="checkInviteCode">
                        <h3 class="text-lg text-orange-600 lighter">{{ __('Have an Invite Code?') }}</h3>
                        <p class="text-sm italic text-slate-800">{{ __('Enter your invite code to join an organization.') }}</p>
                        <div class="mb-3">
                            <x-input-label for="invite" value="{{ __('Invitation Code') }}" />
                            <x-text-input id="invite" type="text" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-primary-button wire:loading.attr="disabled" wire:target="join" class="">
                                {{ __('Join Organization') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>