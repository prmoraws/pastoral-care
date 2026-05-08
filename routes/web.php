<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Feed;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('feed');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/feed', Feed::class)->name('feed');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/registro/{token}', function (string $token) {
    $user = \App\Models\User::where('registration_token', $token)
        ->where('token_expires_at', '>', now())
        ->firstOrFail();
    return view('auth.registro', compact('user'));
})->name('registro.token');

require __DIR__.'/auth.php';