<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 gap-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
        @forelse(Auth::user()->organizations->campaigns as $campaign)
            <a class="transition bg-white border border-slate-200 rounded-lg shadow-sm p-3 group hover:shadow-lg hover:bg-orange-50 hover:border-orange-100 cursor-pointer" href="{{ route('campaign.show', $campaign->slug) }}">
                <h3 class="text-lg text-slate-700 group-hover:text-orange-700 cursor-pointer">{{ $campaign->name }}</h3>
                <small class="italic text-slate-500 group-hover:text-orange-500 cursor-pointer">{{ $campaign->started_at->toFormattedDateString() }} - {{ $campaign->ended_at->toFormattedDateString() }}</small>
                <hr/>
                <span class="text-xs text-center">{{ __(':donations of :recipients gifts have been claimed', ['donations' => $campaign->donations->count() ?? 0, 'recipients' => $campaign->recipients->count() ?? 0]) }}</span>
            </a>
        @empty
            {{ __('No Campaigns Found') }}
        @endforelse
            <a class="transition bg-slate-100 text-center border-dashed border-slate-200 rounded-lg shadow-inner p-3 group hover:bg-orange-50 hover:border-orange-100 cursor-pointer " href="{{ route('campaign.show', $campaign->slug) }}">
                <h3 class="text-lg text-slate-500 group-hover:text-orange-700 cursor-pointer">{{ __('Start a new Campaign') }}</h3>
            </a>
    </div>
</div>
