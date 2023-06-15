<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __(':campaign Recipients', ['campaign' => $campaign->name]) }}
        </h2>
    </x-slot>

    <div class="flex flex-row max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="w-2/3">
            <table class="table border-collapse table-fixed w-full text-sm mb-3">
                <thead>
                    <tr>
                        <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">{{ __('External ID') }}</th>
                        <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">{{ __('Name') }}</th>
                        <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">{{ __('Family') }}</th>
                        <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">{{ __('Donor') }}</th>
                        <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @foreach($recipients as $recipient)
                        <tr class="group cursor-pointer" wire:click="activateRecipient('{{ $recipient->id}}')">
                            <td class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all">{{ $recipient->external_id }}</td>
                            <td wire:click="activateRecipient($recipient->id)" class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all">{{ $recipient->name }}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all">{{ $recipient->group->name }}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all"></td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-3 pl-1 text-slate-500 dark:text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600 transition-all"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $recipients->links() }}
        </div>
        <div class="w-1/3 px-3">
            <div class="flex flex-col bg-white border-slate-300 rounded-lg p-3">
                @if($toggleRecipient)
                    <h3 class="text-lg font-light">{{ __('Recipient') }}</h3>
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
                        {!! QrCode::size(256)->generate('Hello World') !!}
                    @endif
                    <h3 class="text-lg font-light mt-6">{{ __('Donor') }}</h3>
                @else
                    <h3 class="text-lg font-light">{{ __('Select a Recipient') }}</h3>
                    <p class="text-slate-700 text-sm">{{ __('Select a Recipient to manage the details, send reminder emails, or complete edits.') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
