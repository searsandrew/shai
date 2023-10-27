<div class="py-12">
    <x-slot name="header">
        <div class="flex flex-row w-full items-center">
            <h2 class="flex-1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $campaign->name }}
            </h2>
            <livewire:campaign.setting :campaign="$campaign" />
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row">
            <div class="w-full sm:w-1/3 sm:mr-2" wire:poll="loadData">
                <div class="flex flex-col w-full bg-white border py-2 rounded-lg content-center">
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
            </div>
            <div class="w-full sm:w-1/3 sm:mx-2">
                <div class="flex flex-col bg-white border pt-2 mb-2 rounded-lg content-center">
                    <h3 class="text-lg text-lighter text-slate-700 px-3">{{ __('Donors') }}</h3>
                    <div class="divide-y mt-1.5">
                        @forelse($donors as $donor)
                            <div class="group px-3 py-2 cursor-pointer group text-slate-900 hover:bg-red-50 hover:text-red-700 transition-all last:rounded-b-lg" wire:key="{{ $donor->id }}" wire:click="selectDonor('{{ $donor->id }}')">
                                {{ $donor->name }}
                            </div>
                        @empty
                            <p class="pb-2 mx-3">{{ __('Your campaign is active, however, there are no donors signed up yet.') }}</p>
                        @endforelse
                    </div>
                </div>
                {{ $donors->links() }}
                <x-modal name="show-donor-information" :show="$toggleDonorModal" maxWidth="lg" focusable>
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">

                        </h2>
                    </div>
                </x-modal>
            </div>
            <div class="w-full sm:w-1/3 sm:ml-2">
                <div class="flex flex-col bg-white border pt-2 rounded-lg content-center">
                    @if($selectedDonor)

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
