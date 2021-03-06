<?php

use App\Actions\CheckinWishlist;
use App\Actions\ImportCSV;
use App\Actions\PrintLabels;
use App\Actions\UpdateWishlistFromQR;
use App\Actions\SendReminder;
use App\Models\Campaign;
use App\Models\Wishlist;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoneeController;
use App\Http\Livewire\CreateDonee;
use App\Http\Livewire\EditDonee;
use App\Http\Livewire\FamilyCreate;
use App\Http\Livewire\FamilyEdit;
use App\Http\Livewire\CampaignIndex;
use App\Http\Livewire\CampaignCreate;
use App\Http\Livewire\CampaignEdit;
use App\Http\Livewire\CampaignShow;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $current = Campaign::whereDate('started_at', '<=', now())->whereDate('ended_at', '>=', now())->first();
    if(is_null($current))
    {
        $current = (object) [
            'name' => config('app.name'),
            'description' => 'There is no active campaign at this time.',
            'logo' => '',
            'background' => '',
            'icon' => '',
        ];
    }
    
    if(Storage::url($current->background) != '')
    {
        $background = Storage::url($current->background);
    }

    return view('welcome', compact('current'));
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//Route::resource('donee', DoneeController::class);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/donee', [DoneeController::class, 'index'])->name('donee.index');
    Route::get('/donee/create', CreateDonee::class)->name('donee.create');
    Route::get('/donee/{donee}/edit', EditDonee::class)->name('donee.edit');

    Route::get('/family/create', FamilyCreate::class)->name('family.create');
    Route::get('/family/{family}/edit', FamilyEdit::class)->name('family.edit');

    Route::get('/campaigns', CampaignIndex::class)->name('campaign.index');
    Route::get('/campaign/create', CampaignCreate::class)->name('campaign.create');
    Route::get('/campaign/{campaign}/edit', CampaignEdit::class)->name('campaign.edit');
    Route::get('/campaign/{campaign}', CampaignShow::class)->name('campaign.show');
    Route::get('/campaign/{campaign}/print', PrintLabels::class)->name('campaign.print');
    Route::post('/campaign/{campaign}/import', ImportCSV::class)->name('campaign.import');
    Route::post('/campaign/{campaign}/reminder', SendReminder::class)->name('campaign.reminder');

    Route::resource('admin', AdminController::class);

    Route::get('/wishlist/{wishlist}/qr', UpdateWishlistFromQR::class)->name('wishlist.qr');
    Route::get('/wishlist/{wishlist}/collect', function(Wishlist $wishlist) {
        return view('donee.collect', compact('wishlist'));
    })->name('wishlist.collect');
    Route::post('/wishlist/{wishlist}/process', CheckinWishlist::class)->name('wishlist.process');
});

Route::get('/mailable', function () {
    $campaign = App\Models\Campaign::find(1);

    return new App\Mail\DoneeSelected($campaign);
});