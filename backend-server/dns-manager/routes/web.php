<?php

use App\Http\Controllers\CloudflareDNSController;
use App\Http\Controllers\CloudflareIntegrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\SiteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    // servers
    Route::get('servers/{server}/connect', [ServerController::class, 'connect'])->name('servers.connect');
    Route::resource('servers', ServerController::class);

    // sites
    Route::post('sites/{site}/redirect-site-dashboard', [SiteController::class, 'redirectToSiteDashboard'])->name('sites.redirect-to-site-dashboard');
    Route::post('sites/{site}/secret-key/regenerate', [SiteController::class, 'regenerateSecretKey'])->name('sites.secret-key.regenerate');
    Route::resource('sites', SiteController::class);

    Route::prefix('cloudflare-integration')->name('cloudflare-integration.')->group(function() {
        Route::post('/', [CloudflareIntegrationController::class, 'store'])->name('store');
        Route::delete('/', [CloudflareIntegrationController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('cloudflare-dns')->name('cloudflare-dns.')->group(function() {
        Route::get('/', [CloudflareDNSController::class, 'index'])->name('index');
        Route::post('/', [CloudflareDNSController::class, 'store'])->name('store');
    });


    // internal apis for server
    Route::prefix('internal-api')->group(function(){
        Route::post('servers/{server}/execute-command', [ServerController::class, 'executeCommand']);
    });
});

require __DIR__ . '/auth.php';
