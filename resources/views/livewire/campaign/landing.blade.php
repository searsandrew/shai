<div wire:poll="pollingData">
    <x-slot name="header">
        <small class="w-full">{{ __('Logged in as :name', ['name' => $donor->name]) }}</small>
        <h2 class="flex flex-row justify-between">
            <span class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $campaign->name }}</span>
            <form method="POST" action="{{ route('donor.claim', $donor) }}" class="flex flex-row content-center">
                @csrf
                @if($count > 0)
                    <span class="content-center mr-3">{{ __(':count Recipients Selected', ['count' => $count]) }}</span>
                    <x-primary-button type="submit">{{ __('Claim and Logout') }}</x-primary-button>
                @endif
            </form>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="columns-3 gap-3">
                @foreach($collection as $item)
                    <div class="mb-3">
                        <div class="flex flex-row bg-white border border-slate-200 rounded-lg px-3 py-1">
                            @if($toggleGroups)
                                <div class="flex flex-col">
                                    <h3 class="text-lg font-light">{{ $item->name }}</h3>
                                    <small class="text-xs text-slate-400 uppercase tracking-widest mt-3">{{ __('Recipients in Group') }}</small>
                                    <div class="divide-y mt-1">
                                        @foreach($item->recipients as $recipient)
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
                                </div>
                            @endif

                            <span class="flex flex-col mx-auto my-3">
                                {!! QrCode::size(100)->generate(route('recipient.claim', ['group', $item->id])) !!}
                                <x-secondary-button type="button" wire:click="addRecipientToCard('{{ $item->id }}')" class="justify-center mt-3">{{ __('Claim') }}</x-secondary-button>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>