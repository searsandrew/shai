<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $campaign->name }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row">
            <div class="flex flex-col w-full sm:w-1/3 sm:mr-2 bg-white border py-2 rounded-lg content-center" wire:poll="loadData">
                <h3 class="text-lg text-lighter px-3 text-slate-700">{{ __('Recipients') }}</h3>
                <span class="flex flex-row justify-evenly mb-3">
                    <a href="{{ route('recipient.index', $campaign) }}" class="flex flex-col bg-gray-50 cursor-pointer border-slate-200 rounded-lg p-3 transition-all group hover:bg-rose-50 hover:text-rose-600">
                        <h3 class="font-light text-5xl place-self-center">{{ $recipientCount }}</h3>
                        <small class="uppercase tracking-widest text-slate-800 place-self-center">{{ __('Recipients') }}</small>
                    </a>
                    <span class="flex flex-col bg-gray-50 border-slate-200 rounded-lg p-3 cursor-pointer transition-all group hover:bg-rose-50 hover:text-rose-600">
                        <h3 class="font-light text-5xl place-self-center">{{ $donorCount }}</h3>
                        <small class="uppercase tracking-widest text-slate-800 place-self-center">{{ __('Claimed') }}</small>
                    </span>
                    <span class="flex flex-col bg-gray-50 border-slate-200 rounded-lg p-3 cursor-pointer transition-all group hover:bg-rose-50 hover:text-rose-600">
                        <h3 class="font-light text-5xl place-self-center">{{ $recipientCount - $donorCount }}</h3>
                        <small class="uppercase tracking-widest text-slate-800 place-self-center">{{ __('Remaining') }}</small>
                    </span>
                </span>

                @forelse($campaign->files as $file)
                    <a href="{{ route('recipient.import', [$campaign, $file]) }}" class="flex flex-row justify-between px-3 py-1 group hover:bg-rose-50 hover:text-rose-600">
                        <span class="mr-1">{{ $file->name }}</span>
                        <span>{{ ucwords($file->status) }}</span>
                    </a>
                @empty
                    <p class="px-3">{{ __('Please upload a list of Recipients and their wishlists to continue.') }}</p>
                @endforelse
                <span class="px-3">
                    @livewire('recipient.upload', ['campaign' => $campaign])
                </span>
            </div>
            <div class="w-full sm:w-1/3 sm:mx-2">
                <div class="flex flex-col bg-white border pt-2 rounded-lg content-center">
                    <h3 class="text-lg text-lighter text-slate-700 px-3">{{ __('Donors') }}</h3>
                    <div class="divide-y mt-1.5">
                        @forelse($donors as $donor)
                            <div class="group px-3 py-2 cursor-pointer group text-slate-900 hover:bg-red-50 hover:text-red-700 transition-all last:rounded-b-lg">
                                {{ $donor->name }}
                            </div>
                        @empty
                            <p class="pb-2">{{ __('Your campaign is active, however, there are no donors signed up yet.') }}</p>
                        @endforelse
                    </div>
                </div>
                {{ $donors->links() }}
            </div>
            <div class="w-full sm:w-1/3 sm:ml-2">
                <div class="flex flex-col bg-white border pt-2 rounded-lg content-center">
                    <h3 class="text-lg text-lighter text-slate-700 px-3 pt-1">{{ __('Options') }}</h3>
                    <div class="divide-y">
                        <div class="mt-3 flex flex-col sm:flex-row items-center px-2">
                            <div class="input-group w-full sm:mr-1">
                                <span class="flex flex-row items-center">
                                    @if($campaign->toggle_image)
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
                            </div>
                            <div class="input-group w-full sm:mr-1">
                                <span class="flex flex-row items-center">
                                    @if($campaign->toggle_group)
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
                                    <small>{{ __('Use Groups') }}</small>
                                </span>
                            </div>
                            <div class="input-group w-full sm:mr-1">
                                <span class="flex flex-row items-center">
                                    @if($campaign->toggle_privacy)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1 text-orange-600 hover:text-orange-400 transition-all cursor-pointer" fill="currentColor" viewBox="0 0 576 512" wire:click="toggle('privacy', false)">
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
                        </div>
                        @if($toggleSelectionContent)
                            <div class="group px-3 py-2 cursor-pointer bg-red-50 group hover:bg-red-100 transition-all">
                                <h4 class="text-sm uppercase text-wider text-xs text-red-900 group-hover:text-red-800">{{ __('Selection Email Content') }}</h4>
                                <form class="flex flex-row items-start" wire:submit.prevent="saveMeta('selection_content')">
                                    <textarea wire:model="selectionContent" class="w-full border-slate-300 rounded p-3"></textarea>
                                    <div class="flex flex-col gap-y-1 ml-3 place-items-center">
                                        <x-primary-button type="submit">{{ __('Save') }}</x-secondary-button>
                                        <x-secondary-button wire:click="$toggle('toggleSelectionContent')">{{ __('Cancel') }}</x-secondary-button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="group px-3 py-2 cursor-pointer group hover:bg-red-50 transition-all" wire:click="$toggle('toggleSelectionContent')">
                                <h4 class="text-sm uppercase text-wider text-xs text-slate-900 group-hover:text-red-900">{{ __('Selection Email Content') }}</h4>
                                <p class="text-sm group-hover:text-red-700 truncate">{{ $campaign->selection_content }}</p>
                            </div>
                        @endif

                        @if($toggleReminderContent)
                            <div class="group px-3 py-2 cursor-pointer bg-red-50 group hover:bg-red-100 transition-all">
                                <h4 class="text-sm uppercase text-wider text-xs text-red-900 group-hover:text-red-800">{{ __('Reminder Email Content') }}</h4>
                                <form class="flex flex-row items-start" wire:submit.prevent="saveMeta('reminder_content')">
                                    <textarea wire:model="reminderContent" class="w-full border-slate-300 rounded p-3"></textarea>
                                    <div class="flex flex-col gap-y-1 ml-3 place-items-center">
                                        <x-primary-button type="submit">{{ __('Save') }}</x-secondary-button>
                                        <x-secondary-button wire:click="$toggle('toggleReminderContent')">{{ __('Cancel') }}</x-secondary-button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="group px-3 py-2 cursor-pointer group hover:bg-red-50 transition-all" wire:click="$toggle('toggleReminderContent')">
                                <h4 class="text-sm uppercase text-wider text-xs text-slate-900 group-hover:text-red-900">{{ __('Reminder Email Content') }}</h4>
                                <p class="text-sm group-hover:text-red-700 truncate">{{ $campaign->reminder_content }}</p>
                            </div>
                        @endif

                        @if($toggleCompletionContent)
                            <div class="group px-3 py-2 cursor-pointer bg-red-50 group hover:bg-red-100 transition-all">
                                <h4 class="text-sm uppercase text-wider text-xs text-red-900 group-hover:text-red-800">{{ __('Completion Email Content') }}</h4>
                                <form class="flex flex-row items-start" wire:submit.prevent="saveMeta('completion_content')">
                                    <textarea wire:model="completionContent" class="w-full border-slate-300 rounded p-3"></textarea>
                                    <div class="flex flex-col gap-y-1 ml-3 place-items-center">
                                        <x-primary-button type="submit">{{ __('Save') }}</x-secondary-button>
                                        <x-secondary-button wire:click="$toggle('toggleCompletionContent')">{{ __('Cancel') }}</x-secondary-button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="group px-3 py-2 cursor-pointer group hover:bg-red-50 rounded-b-lg transition-all" wire:click="$toggle('toggleCompletionContent')">
                                <h4 class="text-sm uppercase text-wider text-xs text-slate-900 group-hover:text-red-900">{{ __('Completion Email Content') }}</h4>
                                <p class="text-sm group-hover:text-red-700 truncate">{{ $campaign->completion_content }}</p>
                            </div>
                        @endif

                        @if($campaign->toggle_image)
                            <a href="{{ route('campaign.landing', $campaign) }}" target="_new" class="w-full flex flex-row px-3">
                                <strong>Landing Page:</strong> {{ route('campaign.landing', $campaign) }}
                            </a>
                        @endif

                        @if(1 == 2)
                            <form class="flex flex-row items-start" wire:submit.prevent="saveMeta('completion_content')">
                                <div class="flex flex-col flex-initial">
                                    <x-input-label for="landingPageImage" value="{{ __('Campaign Logo') }}" />
                                    <x-text-input id="landingPageImage" type="text" wire:model="landingPageImage" required />
                                    <x-input-error :messages="$errors->get('landingPageImage')" class="mt-2" />
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
