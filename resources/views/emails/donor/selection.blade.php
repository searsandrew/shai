<h1>{{ __('Donation Confirmation') }}</h1>

<p>{{ $campaign->getMeta($type . '_content'); }}</p>

<p>{{ __("Thank you for donating to the :campaignName.\n You will find the list of your recipients below;", ['campaignName' => $campaign->name]) }}</p>
<table>
    <thead>
        <tr>
            <th>{{ __('Name') }}</th>
            @foreach($recipients->first()->getMeta() as $key => $value)
                <th>{{ Str::headline($key) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($recipients as $recipient)
            <tr>
                <td>{{ $recipient->name }}</td>
                @foreach($recipient->getMeta() as $key => $value)
                    <td>{{ Str::headline($value) }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<hr/>

<address>
    <strong>{{ $campaign->organization->name }}</strong><br/>
    <span>{{ $campaign->organization->addresses->first()->street }}</span><br/>
    <span>{{ $campaign->organization->addresses->first()->city }}, {{ $campaign->organization->addresses->first()->state }} {{ $campaign->organization->addresses->first()->zip }}</span>
</address>