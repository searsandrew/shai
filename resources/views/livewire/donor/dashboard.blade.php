<div>
    <h3 class="text-lg">{{ __('Welcome :name', ['name' => $donor->name]) }}</h3>
    <p class="text-slate-600 text-sm leading-4">{{ __('This is your portal for :app. You will be able to review and select additional donations from this screen. Your portal is for all organizations and campaigns using :app.', ['app' => config('app.name')]) }}</p>

    <div class="flex flex-col divide-y mt-6">
        @foreach($recipients as $recipient)
            <span class="flex flex-col bg-slate-100 border-slate-300 rounded-lg px-3 pb-3">
                <h3 class="text-xs uppercase tracking-widest text-slate-300 mt-1">{{ $recipient->campaign->name }}</h3>
                <div class="flex flex-row justify-between items-center">
                    {{ $recipient->name }}
                    <span class="text-sm bg-white px-2 py-1 rounded-lg">{{ ucwords(strtolower($recipient->pivot->status)) }}</span>
                </div>
                <div class="flex flex-row flex-wrap mt-3">
                    @foreach($recipient->getMeta() as $name => $meta)
                        <div class="flex-1 flex flex-row text-sm mx-2 mb-2">
                            <span class="bg-slate-300 text-slate-600 rounded-l-lg w-fit px-2">{{ $name }}</span>
                            <span class="bg-white text-slate-800 rounded-r-lg shadow-inner font-semibold w-fit px-2">{{ $meta }}</span>
                        </div>
                    @endforeach
                </div>
            </span>
        @endforeach
    </div>
</div>
