<h1>{{ __('Donation Complete') }}</h1>

<p>{{ $campaign->getMeta($type . '_content'); }}</p>

<p>{{ __("Thank you for participating in the :campaignName campaign, your generosity helps make the world a better place.", ['campaignName' => $campaign->name]) }}</p>

<hr/>

<address>
    <strong>{{ $campaign->organization->name }}</strong><br/>
    <span>{{ $campaign->organization->addresses->first()->street }}</span><br/>
    <span>{{ $campaign->organization->addresses->first()->city }}, {{ $campaign->organization->addresses->first()->state }} {{ $campaign->organization->addresses->first()->zip }}</span>
</address>