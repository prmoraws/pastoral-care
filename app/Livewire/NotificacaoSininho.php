<?php

namespace App\Livewire;

use App\Models\Notificacao;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificacaoSininho extends Component
{
    public bool $aberto = false;

    public function toggleAberto(): void
    {
        $this->aberto = !$this->aberto;
    }

    public function marcarTodasLidas(): void
    {
        Notificacao::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function render()
    {
        $notificacoes = Notificacao::where('user_id', Auth::id())
            ->latest('created_at')
            ->limit(10)
            ->get();

        $naoLidas = $notificacoes->whereNull('read_at')->count();

        return view('livewire.notificacao-sininho', compact('notificacoes', 'naoLidas'));
    }
}