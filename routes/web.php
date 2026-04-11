<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class)->name('home');
Route::get('/search', \App\Livewire\SearchPage::class)->name('search');
Route::get('/category/{slug}', \App\Livewire\CategoryPage::class)->name('seo.category');
Route::get('/city/{city}/{category}', \App\Livewire\CityCategoryPage::class)->name('seo.city.category');
Route::get('/professionals/{id}', \App\Livewire\ProfessionalProfilePage::class)->name('profile.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\LoginPage::class)->name('login');
    Route::get('/register', \App\Livewire\Auth\RegisterPage::class)->name('register');
});

Route::get('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', \App\Livewire\UserDashboard::class)->name('dashboard');
    Route::get('/pro-dashboard', \App\Livewire\ProfessionalDashboard::class)->name('pro.dashboard');
    Route::get('/upgrade', \App\Livewire\UpgradePage::class)->name('upgrade');
    Route::get('/requests/create', \App\Livewire\CreateRequestPage::class)->name('requests.create');
    
    // Admin-only route for viewing private identity documents
    Route::get('/admin/identity-document', function (\Illuminate\Http\Request $request) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        
        $path = $request->query('path');
        if (!$path || !\Illuminate\Support\Facades\Storage::disk('local')->exists($path)) {
            abort(404, 'Identity document not found.');
        }
        
        return response()->file(\Illuminate\Support\Facades\Storage::disk('local')->path($path));
    })->name('admin.identity-document.show');

    // Admin-only route for viewing private verification documents
    Route::get('/admin/verification-document', function (\Illuminate\Http\Request $request) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        $path = $request->query('path');
        if (!$path || !\Illuminate\Support\Facades\Storage::disk('local')->exists($path)) {
            abort(404, 'Verification document not found.');
        }

        return response()->file(\Illuminate\Support\Facades\Storage::disk('local')->path($path));
    })->name('admin.verification-document.show');

    // User-facing verification request page
    Route::get('/request-verification', \App\Livewire\RequestVerificationPage::class)->name('verification.request');
});

Route::get('/requests', \App\Livewire\PublicRequestsPage::class)->name('requests.index');
Route::get('/requests/{id}', \App\Livewire\ViewRequestPage::class)->name('requests.show');

require __DIR__.'/settings.php';

