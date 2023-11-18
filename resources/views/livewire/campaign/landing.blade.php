<div>
    <x-slot name="header">
        <small class="w-full">{{ __('Logged in as :name', ['name' => $donor->name]) }}</small>
        <h2 class="flex flex-row justify-between">
            <span class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $campaign->name }}</span>
            <form method="POST" action="{{ route('donor.claim', $donor) }}" class="flex flex-row content-center">
                @csrf
                @if($count > 0)
                    @livewire('donor.selection', ['count' => $count, 'donor' => $donor, 'campaign' => $campaign])
                    <x-primary-button type="submit">{{ __('Claim and Logout') }}</x-primary-button>
                @else
                    <x-primary-button type="submit">{{ __('Logout') }}</x-primary-button>
                @endif
            </form>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
        </div>
    </div>
</div>
