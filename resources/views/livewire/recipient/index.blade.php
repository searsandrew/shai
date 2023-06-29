<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __(':campaign Recipients', ['campaign' => $campaign->name]) }}
        </h2>
    </x-slot>

    <div class="flex flex-col-reverse sm:flex-row max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="w-full sm:w-2/3">
            <table class="table border-collapse table-fixed w-full text-sm mb-3">
                <thead>
                    <tr>
                        <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">{{ __('External ID') }}</th>
                        @if($toggleGroups)
                            <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">{{ __('Group') }}</th>
                            <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-center">{{ __('Qty in Group') }}</th>
                        @else
                            <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">{{ __('Name') }}</th>
                            <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">{{ __('Group') }}</th>
                        @endif
                        <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">{{ __('Donor') }}</th>
                        <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-center text-slate-400 dark:text-slate-200 text-left">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @foreach($list as $item)
                        <tr class="group cursor-pointer" wire:click="activateItem('{{ $item->id}}')">
                            <td class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all">{{ $item->external_id }}</td>
                            @if($toggleGroups)
                                <td wire:click="activateItem($item->id)" class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all">{{ $item->name }}</td>
                                <td class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-center text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all">{{ $item->recipients()->count() }}</td>
                            @else
                                <td wire:click="activateItem($item->id)" class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all">{{ $item->name }}</td>
                                <td class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all">{{ $item->group->name }}</td>
                            @endif
                            <td class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all">{{ $item->donors->first()->name ?? '' }}</td>
                            <td class="capitalize text-center border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all">{{ $item->donors->first()->pivot->status ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $list->links() }}
        </div>
        <div class="w-full sm:w-1/3 px-3">
            <div class="flex flex-col bg-white border-slate-300 rounded-lg p-3">
                @if($toggleRecipient)
                    @if($toggleEditRecipient)
                        <dl class="text-slate-700 text-sm flex flex-col">
                            <div class="input-group flex flex-col">
                                <x-input-label for="recipient.name">{{ __('Name') }}</x-input-label>
                                <x-text-input type="text" wire:model="recipient.name" />
                            </div>
                            @foreach($meta as $key => $value)
                                <div class="input-group flex flex-col mt-3">
                                    <x-input-label for="recipient.{{ $key }}">{{ Str::headline($key) }}</x-input-label>
                                    <x-text-input type="text" wire:model="recipient.{{ $key }}" />
                                </div>
                            @endforeach
                        </dl>
                    @else
                        <span class="mx-auto my-3">
                            {!! QrCode::size(256)->generate($claimCode) !!}
                        </span>
                    @endif
                    @if($toggleGroups)
                        <small class="text-xs text-slate-400 uppercase tracking-widest">{{ __('Group Name') }}</small>
                        <h3 class="text-lg font-light">{{ $this->group->name }}</h3>
                        <small class="text-xs text-slate-400 uppercase tracking-widest mt-3">{{ __('Recipients in Group') }}</small>
                        <div class="divide-y mt-1">
                            @foreach($this->group->recipients as $recipient)
                                <div class="flex flex-wrap py-3 first:pt-0">
                                    <h4 class="w-full">{{ $recipient->name }}</h4>
                                    @foreach($recipient->getMeta() as $key => $value)
                                        <div class="mr-3 text-sm">
                                            <span class="font-bold">{{ Str::headline($key) }}</span>: {{ Str::headline($value) }}
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if($group->donors()->count() > 0)
                        <div class="flex flex-row justify-between border-t-4 border-slate-100 items-center">
                            <span class="flex flex-col">
                                <h3 class="flex flex-row justify-between text-lg font-light mt-1 pt-2">
                                    {{ __('Donor') }}
                                </h3>
                                <span class="">{{ $group->donors()->first()->name }}</span>
                                <a class="text-sm text-slate-500" href="mailto:{{ $group->donors()->first()->email }}">{{ $group->donors()->first()->email }}</a>
                            </span>
                            <span class="flex flex-row">
                                <span class="flex flex-col place-items-center p-2 mr-2 rounded-lg cursor-pointer border-slate-100 text-slate-300 border group hover:text-red-600 hover:border-red-300 hover:bg-red-50 hover:shadow-none transform-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 448 512">
                                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/>
                                    </svg>
                                    <span class="text-xs text-slate-500 group-hover:text-red-800">{{ __('Remove') }}</span>
                                </span>
                                <x-secondary-button
                                    class="flex flex-col place-items-center p-2 rounded-lg normal-case tracking-normal font-normal cursor-pointer border-slate-100 text-slate-300 border group hover:text-emerald-600 hover:border-emerald-300 hover:bg-emerald-50 hover:shadow-none transform-all"
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'manually-send-email')" >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 512 512">
                                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480V396.4c0-4 1.5-7.8 4.2-10.7L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4z"/>
                                    </svg>
                                    <span class="text-xs text-slate-500 group-hover:text-emerald-800">{{ __('Email') }}</span>
                                </x-secondary-button>
                            </span>
                        </div>


                        <div class="flex flex-row justify-between border-t-4 mt-3 border-slate-100 items-center">
                            <span class="flex flex-col w-full">
                                <h3 class="flex flex-row justify-between text-lg font-light pt-3">
                                    {{ __('Communication') }}
                                </h3>
                                @forelse(\App\Models\Communication::where('donor_recipient_id', $group->donors()->first()->pivot->id)->get() as $communication)
                                    <div class="flex flex-row py-2 border-b border-slate-200 last:border-b-0 justify-between">
                                        <span class="text-xs py-0.5 px-1 uppercase bg-slate-100 text-slate-600 rounded">
                                            {{ $communication->type}}
                                        </span>
                                        <span class="text-sm text-slate-700">
                                            {{ $communication->created_at->timezone(Auth::user()->timezone)->toDayDateTimeString() }}
                                        </span>
                                    </div>
                                @empty
                                    <h3 class="text-lg font-light">{{ __('No Emails Sent') }}</h3>
                                    <p class="text-slate-700 text-sm">{{ __('There are no records of emails being sent to this Donor.') }}</p>
                                @endforelse
                            </span>
                        </div>
                    @else
                        <div class="flex flex-col border-t-4 border-slate-100">
                            <h3 class="text-lg font-light mt-1 pt-2">
                                {{ __('Donor') }}
                            </h3>
                            <em class="text-slate-700 mb-3">{{ __('Recipient Unclaimed') }}</em>
                            <form wire:submit.prevent="manuallyAddRecipient('{{ $group->id }}')">
                                <div class="input-group flex flex-col mt-3 content-evenly">
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" wire:model="name" :value="old('name')" required autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />    
                                </div>

                                <div class="input-group flex flex-col mt-3 content-evenly">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" wire:model="email" :value="old('email')" required autocomplete="email" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                
                                <x-primary-button type="submit" wire:loading.attr="disabled" class="mt-3">{{ __('Manually Add Donor') }}</x-primary-button>
                            </form>
                        </div>
                    @endif
                @else
                    <h3 class="text-lg font-light">{{ __('Select a Recipient') }}</h3>
                    <p class="text-slate-700 text-sm">{{ __('Select a Recipient to manage the details, send reminder emails, or complete edits.') }}</p>
                @endif
            </div>
        </div>
    </div>

    <x-modal name="manually-send-email" :show="$modal" maxWidth="sm" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Manually Send Email') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Emails are automatically send to Donors, however, they can be sent manually below. Select the type of email you\'d like to send, and click submit.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="emailType" :value="__('Type of Email')" />
                <select id="emailType" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" wire:model="emailType">
                    <option value="selection">{{ __('Selection Email') }}</option>
                    <option value="reminder">{{ __('Reminder Email') }}</option>
                    <option value="completion">{{ __('Completion Email') }}</option>
                </select>
                <x-input-error :messages="$errors->get('emailType')" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
    
                <x-primary-button class="ml-3" wire:click="manuallySendEmail()" x-on:click="$dispatch('close')">
                    {{ __('Send Email') }}
                </x-primary-button>
            </div>
        </div>
    </x-model>
</div>
