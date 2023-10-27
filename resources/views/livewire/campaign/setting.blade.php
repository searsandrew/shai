<div>
    <x-secondary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'campaign-settings')">
        {{ __('Settings') }}
    </x-secondary-button>

    <x-modal name="campaign-settings" :show="$modal" maxWidth="md" focusable>
        <h3 class="flex flex-row text-lg text-lighter items-center text-slate-700 px-3 pt-3">
            <span class="flex-1">{{ __('Options') }}</span>
            <x-secondary-button class="px-0 py-0 border-none" x-on:click="$dispatch('close')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" height="1em" viewBox="0 0 384 512">
                    <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                </svg>
            </x-secondary-button>
        </h3>
        <div class="divide-y mb-2">
            <div class="mt-3 flex flex-col sm:flex-row items-center px-2 pb-2">
                <div class="input-group w-full sm:mr-1">
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
                </div>
                <div class="input-group w-full sm:mr-1">
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
                        <small>{{ __('Use Groups') }}</small>
                    </span>
                </div>
                <div class="input-group w-full sm:mr-1">
                    <span class="flex flex-row items-center">
                        @if($togglePrivacy)
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
            <div class="group px-3 py-2 cursor-pointer group hover:bg-slate-50 transition-all">
                <h4 class="text-sm uppercase text-wider text-xs text-slate-800 group-hover:text-slate-900">{{ __('Selection Email Content') }}</h4>
                <textarea wire:model="selectionContent" class="w-full border-slate-300 rounded p-3 focus:ring-amber-500"></textarea>
            </div>
            <div class="group px-3 py-2 cursor-pointergroup hover:bg-slate-50 transition-all">
                <h4 class="text-sm uppercase text-wider text-xs text-slate-800 group-hover:text-slate-900">{{ __('Reminder Email Content') }}</h4>
                <textarea wire:model="reminderContent" class="w-full border-slate-300 rounded p-3"></textarea>
            </div>
            <div class="group px-3 py-2 cursor-pointergroup hover:bg-slate-50 transition-all">
                <h4 class="text-sm uppercase text-wider text-xs text-slate-800 group-hover:text-slate-900">{{ __('Completion Email Content') }}</h4>
                <textarea wire:model="completionContent" class="w-full border-slate-300 rounded p-3"></textarea>
            </div>

            @if($toggleUploadAttachment)
                <div class="group px-3 py-2 cursor-pointer bg-red-50 group hover:bg-red-100 transition-all">
                    <h4 class="text-sm uppercase text-wider text-xs text-slate-800 group-hover:text-slate-900">{{ __('Email Attachment (if applicable)') }}</h4>
                    <form wire:submit.prevent="uploadAttachment">
                        <div
                            class="flex flex-col justify-between mt-3"
                            x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                        >
                            <!-- File Input -->
                            <input type="file" wire:model="attachment">

                            <!-- Progress Bar -->
                            <div x-show="isUploading">
                                <progress max="100" x-bind:value="progress"></progress>
                            </div>
                        </div>

                        @error('file') <span class="error">{{ $message }}</span> @enderror

                        <x-primary-button type="submit" class="mt-3">{{ __('Upload Attachment') }}</x-primary-button>
                        <x-secondary-button wire:click="$toggle('toggleUploadAttachment')">{{ __('Cancel') }}</x-secondary-button>
                    </form>
                </div>
            @else
                <div class="group px-3 py-2 cursor-pointer group hover:bg-red-50 rounded-b-lg transition-all" wire:click="$toggle('toggleUploadAttachment')">
                    <h4 class="text-sm uppercase text-wider text-xs text-slate-900 group-hover:text-red-900">{{ __('Email Attachment (if applicable)') }}</h4>
                    <p class="text-sm group-hover:text-red-700 truncate">{{ $activeAttachment }}</p>
                </div>
            @endif

            @if($campaign->toggle_image)
                <span class="w-full flex flex-col pt-2 px-3">
                    <h4 class="w-full text-sm uppercase text-wider text-xs text-slate-900">{{ __('Landing Page') }}</h4>
                    <a href="{{ route('campaign.landing', $campaign) }}" class="text-sm hover:underline hover:text-red-900" target="_new">{{ route('campaign.landing', $campaign) }}</a>
                </span>
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
    </x-modal>
</div>
