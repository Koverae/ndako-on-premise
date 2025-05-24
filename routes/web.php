<?php

use App\Http\Controllers\Auth\GetStartedController;
use App\Http\Controllers\NdakoInstallerController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Dashboard;
use App\Livewire\Dashboards\Overview;
use Illuminate\Support\Facades\Route;
use Modules\ChannelManager\Http\Controllers\Embed\BookingFormController;
use Modules\App\Livewire\GettingStarted;
use Modules\App\Livewire\Onboarding;

Route::get('/install', [NdakoInstallerController::class, 'show'])->name('ndako.show');
Route::post('/install', [NdakoInstallerController::class, 'install'])->name('ndako.install');

Route::get('/', function () {
    return redirect('/web');
});

Route::middleware(['auth', 'verified', 'identify-kover', 'subscribed', 'twofactor'])->prefix('web')->group(function () {

    Route::get('/onboarding', Onboarding::class)->name('onboarding');
    Route::get('/', Overview::class)->name('dashboard');
});

