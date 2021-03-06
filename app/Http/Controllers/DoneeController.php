<?php

namespace App\Http\Controllers;

use App\Models\Donee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;

class DoneeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index() : \Illuminate\View\View
    {
        $campaigns = Auth::user()->wishlists->groupBy('campaign_id');
        // $donees = $donees->groupBy('campaign_id');
        // dd($donees);
        return view('donee.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() : \Illuminate\View\View
    {
        $this->authorize('donee_create');

        return view('donee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) : \Illuminate\Http\RedirectResponse
    {
        $this->authorize('donee_create');

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $donee = Donee::create($validated);

        return redirect(route('donee.show', $donee))->with('success', sprintf('%s has been added.', $validated->name));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donee  $donee
     * @return \Illuminate\View\View
     */
    public function show(Donee $donee) : \Illuminate\View\View
    {
        return view('donee.show', compact('donee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donee  $donee
     * @return \Illuminate\View\View
     */
    public function edit(Donee $donee) : \Illuminate\View\View
    {
        $this->authorize('donee_edit');

        return view('donee.edit', compact('donee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donee  $donee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Donee $donee) : \Illuminate\Http\RedirectResponse
    {
        $this->authorize('donee_edit');

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $donee->update($validated);

        return redirect(route('donee.show', $donee))->with('success', sprintf('%s has been updated', $validated->name));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donee  $donee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donee $donee)
    {
        $this->authorize('donee_edit');

        $donee->delete();

        return redirect(route('donee.index'))->with('success', 'Donee has been deleted. You may recover this record for 30 days.');
    }
}
