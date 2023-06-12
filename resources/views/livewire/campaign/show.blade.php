<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row">
            <div class="flex flex-col w-full sm:w-1/3 sm:mr-2 bg-white border px-3 pb-2 pt-1 rounded-lg content-center">
                <h3 class="text-lg text-lighter text-slate-700">{{ __('Recipients') }}</h3>
                <p>{{ __('Please upload a list of Recipients and their wishlists to continue.') }}</p>
            </div>
            <div class="flex flex-col w-full sm:w-1/3 sm:mx-2 bg-white border px-3 pb-2 pt-1 rounded-lg content-center">
                <h3 class="text-lg text-lighter text-slate-700">{{ __('Donors') }}</h3>
                <p>{{ __('Your campaign is active, however, there are no donors signed up yet.') }}</p>
            </div>
            <div class="flex flex-col w-full sm:w-1/3 sm:ml-2 bg-white border pt-1 rounded-lg content-center">
                <h3 class="text-lg text-lighter text-slate-700 px-3 pt-1">{{ __('Options') }}</h3>
                <div class="divide-y">
                    <div class="mt-3 flex flex-col sm:flex-row items-center px-2">
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
                    @if($toggleTransactionalContent)
                        <div class="group px-3 py-2 cursor-pointer bg-red-50 group hover:bg-red-100 transition-all">
                            <h4 class="text-sm uppercase text-wider text-xs text-red-900 group-hover:text-red-800">{{ __('Transactional Email Content') }}</h4>
                            <form class="flex flex-row items-start" wire:submit.prevent="saveMeta('transactional_content')">
                                <textarea wire:model="transactionalContent" class="w-full border-slate-300 rounded p-3"></textarea>
                                <div class="flex flex-col gap-y-1 ml-3 place-items-center">
                                    <x-primary-button type="submit">{{ __('Save') }}</x-secondary-button>
                                    <x-secondary-button wire:click="$toggle('toggleTransactionalContent')">{{ __('Cancel') }}</x-secondary-button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="group px-3 py-2 cursor-pointer group hover:bg-red-50 transition-all" wire:click="$toggle('toggleTransactionalContent')">
                            <h4 class="text-sm uppercase text-wider text-xs text-slate-900 group-hover:text-red-900">{{ __('Transactional Email Content') }}</h4>
                            <p class="text-sm group-hover:text-red-700 truncate">{{ $campaign->transactional_content }}</p>
                        </div>
                    @endif

                    @if($toggleInstructionalContent)
                        <div class="group px-3 py-2 cursor-pointer bg-red-50 group hover:bg-red-100 transition-all">
                            <h4 class="text-sm uppercase text-wider text-xs text-red-900 group-hover:text-red-800">{{ __('Instructional Email Content') }}</h4>
                            <form class="flex flex-row items-start" wire:submit.prevent="saveMeta('instructional_content')">
                                <textarea wire:model="instructionalContent" class="w-full border-slate-300 rounded p-3"></textarea>
                                <div class="flex flex-col gap-y-1 ml-3 place-items-center">
                                    <x-primary-button type="submit">{{ __('Save') }}</x-secondary-button>
                                    <x-secondary-button wire:click="$toggle('toggleInstructionalContent')">{{ __('Cancel') }}</x-secondary-button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="group px-3 py-2 cursor-pointer group hover:bg-red-50 transition-all" wire:click="$toggle('toggleInstructionalContent')">
                            <h4 class="text-sm uppercase text-wider text-xs text-slate-900 group-hover:text-red-900">{{ __('Instructional Email Content') }}</h4>
                            <p class="text-sm group-hover:text-red-700 truncate">{{ $campaign->instructional_content }}</p>
                        </div>
                    @endif

                    @if($togglePrivacyContent)
                        <div class="group px-3 py-2 cursor-pointer bg-red-50 group hover:bg-red-100 transition-all">
                            <h4 class="text-sm uppercase text-wider text-xs text-red-900 group-hover:text-red-800">{{ __('Privacy Email Content') }}</h4>
                            <form class="flex flex-row items-start" wire:submit.prevent="saveMeta('privacy_content')">
                                <textarea wire:model="privacyContent" class="w-full border-slate-300 rounded p-3"></textarea>
                                <div class="flex flex-col gap-y-1 ml-3 place-items-center">
                                    <x-primary-button type="submit">{{ __('Save') }}</x-secondary-button>
                                    <x-secondary-button wire:click="$toggle('togglePrivacyContent')">{{ __('Cancel') }}</x-secondary-button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="group px-3 py-2 cursor-pointer group hover:bg-red-50 transition-all" wire:click="$toggle('togglePrivacyContent')">
                            <h4 class="text-sm uppercase text-wider text-xs text-slate-900 group-hover:text-red-900">{{ __('Privacy Email Content') }}</h4>
                            <p class="text-sm group-hover:text-red-700 truncate">{{ $campaign->privacy_content }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
