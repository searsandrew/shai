<div>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <div class="flex flex-col">
                <small class="w-full">{{ __('Logged in as :name', ['name' => $donor->name]) }}</small>
                <span class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $campaign->name }}</span>
            </div>
            <form method="POST" action="{{ route('donor.claim', $donor) }}" class="flex flex-row content-center">
                @csrf
                @if($count > 0)
                    @livewire('donor.selection', ['count' => $count, 'donor' => $donor, 'campaign' => $campaign])
                    <x-primary-button type="submit">{{ __('Claim and Logout') }}</x-primary-button>
                @else
                    <x-primary-button type="submit">{{ __('Logout') }}</x-primary-button>
                @endif
            </form>
        </div>
    </x-slot>

    <div class="flex flex-col content-center mx-auto sm:px-6 lg:px-8 space-y-6">
        <img src="https://placehold.co/1024x400" />
{{--        <div class="flex flex-row space-x-3">--}}
{{--            @foreach($options as $title => $option)--}}
{{--                <div class="flex flex-1 flex-col">--}}
{{--                    <x-input-label for="{{ $title }}Group">{{ Str::headline($title) }}</x-input-label>--}}
{{--                    <select wire:change="setFilter('{{ $title }}')" wire:model="filter" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">--}}
{{--                        <option value="x">{{ __('Select One') }}</option>--}}
{{--                        @forelse($option as $selection)--}}
{{--                            <option value="{{ $selection }}" class="truncate">{{ Str::headline($selection) }}</option>--}}
{{--                        @empty--}}
{{--                            <option disabled>{{ __('No Groups') }}</option>--}}
{{--                        @endforelse--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
        <div class="columns-3 gap-3">
            @foreach($collection as $item)
                <div class="mb-3" wire:key="card-{{ $item->id }}">
                    <div class="flex flex-row bg-white border border-slate-200 rounded-lg px-3 py-1">
                        @if($campaign->toggle_group)
                            <div class="flex flex-col">
                                <h3 class="text-lg font-light mt-1">
                                    @if($campaign->toggle_privacy)
                                        {{ __('Group :id',['id' => $item->external_id]) }}
                                    @else
                                        {{ $item->name }}
                                    @endif
                                </h3>
                                <small class="text-xs text-slate-400 uppercase tracking-widest">{{ __('Recipients in Group') }}</small>
                                <div class="divide-y mt-1">
                                    @foreach($item->recipients as $recipient)
                                        <div class="flex flex-wrap py-3 first:pt-0">
                                            <h4 class="w-full font-semibold">{{ $recipient->name }}</h4>
                                            @foreach($recipient->getMeta() as $key => $value)
                                                <div class="mr-3 text-sm">
                                                    <span class="font-bold">{{ Str::headline($key) }}</span>: {{ Str::headline($value) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col w-full">
                                <h3 class="text-lg font-light">
                                    @if($campaign->toggle_privacy)
                                        {{ __('Recipient :id',['id' => $item->external_id]) }}
                                    @else
                                        {{ $item->name }}
                                    @endif
                                </h3>
                                <div class="divide-y mt-1">
                                    @foreach($item->getMeta() as $key => $value)
                                        <div class="mr-3 text-sm">
                                            <span class="font-bold">{{ Str::headline($key) }}</span>: {{ Str::headline($value) }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <form class="flex flex-col w-28 mx-auto my-3" method="POST" action="{{ route('recipient.hold', ['campaign' => $campaign, 'ulid' => $item->id]) }}">
                            @csrf
                            @if($item->toggle_scanner)
                                {!! QrCode::size(100)->generate(route('recipient.claim', [
                                    ($campaign->toggle_group ? 'group' : 'recipient'),
                                    $item->id
                                ])) !!}
                            @endif
                            <x-secondary-button type="submit" class="justify-center mt-3">{{ __('Claim') }}</x-secondary-button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="w-1/2 m-auto pb-6">
            {{ $collection->links() }}
        </div>
    </div>
</div>