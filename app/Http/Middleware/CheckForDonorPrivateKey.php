<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Recipient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForDonorPrivateKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Recipient::find($request->recipient))
        {
            $recipient = Recipient::find($request->recipient);
            if($recipient->held_at == null)
            {
                $recipient->update(['held_at' => Carbon::now()->toDateTimeString()]);
                $request->session()->put('shaiHoldRecipient', $request->recipient);
            }
        }

        if(!$request->cookie('shai_public_key'))
        {
            return redirect(route('donor.register'));
        }

        return $next($request);
    }
}