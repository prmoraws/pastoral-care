<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Feed;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('feed');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/feed', Feed::class)->name('feed');
});

Route::get('/registro/{token}', function (string $token) {
    $user = \App\Models\User::where('registration_token', $token)
        ->where('token_expires_at', '>', now())
        ->firstOrFail();

    return view('auth.registro', compact('user'));
})->name('registro.token');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');