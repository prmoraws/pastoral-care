<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Feed;
use App\Livewire\EditarPerfil;
use App\Livewire\GerarConvite;
use App\Livewire\AceitarConvite;
use App\Models\Convite;

Route::get('/', function () {
    return redirect()->route('feed');
});

Route::get('/perfil/{user}', function (\App\Models\User $user) {
    return view('perfil', compact('user'));
})->name('perfil')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/feed', Feed::class)->name('feed');
    Route::get('/perfil/{user}', function (\App\Models\User $user) {
        return view('perfil', compact('user'));
    })->name('perfil');
    Route::get('/meu-perfil', EditarPerfil::class)->name('meu-perfil');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/convites', GerarConvite::class)->name('convites');
});

Route::get('/convite/{token}', function (string $token) {
    $convite = \App\Models\Convite::where('token', $token)->firstOrFail();

    if (!$convite->isValido()) {
        abort(410, 'Este convite não é mais válido ou já foi utilizado.');
    }

    return view('convite', compact('convite'));
})->name('convite.aceitar');

Route::get('/convite/{token}', function (string $token) {
    $convite = \App\Models\Convite::where('token', $token)->first();

    if (!$convite || !$convite->isValido()) {
        return view('convite-invalido');
    }

    return view('convite', compact('convite'));
})->name('convite.aceitar');

require __DIR__ . '/auth.php';
