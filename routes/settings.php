<?php

use App\Livewire\SettingsPage;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/settings', SettingsPage::class)->name('settings');
    // We leave old names pointing here temporarily in case of hardcoded route() calls elsewhere,
    // but the actual page loaded is the unified custom SettingsPage.
    Route::get('/settings/profile', function() {
        return redirect()->route('settings');
    })->name('profile.edit');
});
