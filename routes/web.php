<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Campaign\Index as CampaignIndex;
use App\Http\Livewire\Campaign\Landing as CampaignLanding;
use App\Http\Livewire\Campaign\Show as CampaignShow;
use App\Http\Livewire\Donor\Dashboard as DonorDashboard;
use App\Http\Livewire\Donor\Register as DonorRegister;
use App\Actions\Donor\Setup as DonorSetup;
use App\Actions\Recipient\Claim as RecipientClaim;
use App\Actions\Recipient\Create as RecipientCreate;
use App\Http\Livewire\Recipient\Import as RecipientImport;
use App\Http\Livewire\Recipient\Index as RecipientIndex;

use App\Actions\Organization\Set as OrganizationSet;
use App\Http\Livewire\Organization\Setup as OrganizationSetup;
use App\Http\Livewire\Organization\Select as OrganizationSelect;
use App\Http\Livewire\Organization\Manage as OrganizationManage;


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
    Route::get('/{organization}/manage', OrganizationManage::class)->name('organization.manage');
});

Route::middleware(['auth', 'organization'])->prefix('campaign')->group(function() {
    Route::get('/', CampaignIndex::class)->name('campaign.index');
    Route::get('/{campaign}', CampaignShow::class)->name('campaign.show');
    Route::prefix('{campaign}/recipient')->group(function() {
        Route::get('/', RecipientIndex::class)->name('recipient.index');
        Route::post('/create', RecipientCreate::class)->name('recipient.create');
        Route::get('/import/{file}', RecipientImport::class)->name('recipient.import');
    });
});

Route::get('/donor/register', DonorRegister::class)->name('donor.register');
Route::post('/donor/setup', DonorSetup::class)->name('donor.setup');
Route::middleware(['donor'])->group(function() {
    Route::get('/campaign/{campaign}/landing', CampaignLanding::class)->name('campaign.landing');
    Route::get('/claim/{type}/{ulid}', RecipientClaim::class)->name('recipient.claim');
    Route::get('/donor', DonorDashboard::class)->name('donor.dashboard');
});


Route::get('/donor/clear', function(){
    // session()->flush();
});

require __DIR__.'/auth.php';
