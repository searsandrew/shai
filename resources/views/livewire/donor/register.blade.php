<div>
    <h3 class="text-lg">{{ __('Welcome to :app', ['app' => config('app.name')]) }}</h3>
    <p class="text-slate-600 text-sm leading-4">{{ __('To participate in a donation campaign, we need your name and email address. That\'s it!') }}</p>
    <form method="POST" action="{{ route('donor.setup') }}">
        @csrf
        <input type="hidden" name="recipient" value="{{ session('shaiHoldRecipient') }}" />
        <div class="input-group flex flex-col mt-3">
            <x-input-label for="name">{{ __('Your Name') }}</x-input-label>
            <x-text-input type="text" name="name" />
        </div>
        <div class="input-group flex flex-col mt-3">
            <x-input-label for="email">{{ __('Your Email') }}</x-input-label>
            <x-text-input type="text" name="email" />
        </div>
        <x-primary-button type="submit" class="mt-6">{{ __('Register') }}</x-primary-button>
    </form>
</div>
