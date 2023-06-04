<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Campaign\Index as CampaignIndex;

use App\Actions\Organization\Set as OrganizationSet;
use App\Http\Livewire\Organization\Setup as OrganizationSetup;
use App\Http\Livewire\Organization\Select as OrganizationSelect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'organization'])->name('dashboard');

Route::middleware(['auth', 'organization'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('organization')->group(function() {
    Route::get('/set/{organization}', OrganizationSet::class)->name('organization.set');
    Route::get('/setup', OrganizationSetup::class)->name('organization.setup');
    Route::get('/select', OrganizationSelect::class)->name('organization.select');
});

Route::middleware(['auth', 'organization'])->prefix('campaign')->group(function() {
    Route::get('/', CampaignIndex::class)->name('campaign.index');
});

require __DIR__.'/auth.php';
