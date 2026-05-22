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

        $this->aberto = false;
    }

    public function render()
    {
        $notificacoes = Notificacao::where('user_id', Auth::id())
            ->where(function ($q) {
                $q->whereNull('read_at')
                    ->orWhere('read_at', '>=', now()->subDay());
            })
            ->latest('created_at')
            ->limit(10)
            ->get();

        $naoLidas = $notificacoes->whereNull('read_at')->count();

        return view('livewire.notificacao-sininho', compact('notificacoes', 'naoLidas'));
    }
}
