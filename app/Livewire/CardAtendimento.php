<?php

namespace App\Livewire;

use App\Models\Atendimento;
use App\Models\Comentario;
use App\Models\Curtida;
use App\Models\Notificacao;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CardAtendimento extends Component
{
    public Atendimento $atendimento;
    public string $novoComentario = '';
    public bool $mostrarComentarios = false;

    public function curtir(): void
    {
        $user = Auth::user();

        // Verifica permissão
        if (!$user->hasRole('editor') && $atendimento->pessoa->user_id !== $user->id) {
            return;
        }

        $curtida = Curtida::where('user_id', $user->id)
            ->where('atendimento_id', $this->atendimento->id)
            ->first();

        if ($curtida) {
            $curtida->delete();
            $this->atendimento->decrement('curtidas_count');
        } else {
            Curtida::create([
                'user_id'        => $user->id,
                'atendimento_id' => $this->atendimento->id,
            ]);
            $this->atendimento->increment('curtidas_count');
        }

        $this->atendimento->refresh();
    }

    public function comentar(): void
    {
        $this->validate(['novoComentario' => 'required|min:2|max:500']);

        $user = Auth::user();

        $comentario = Comentario::create([
            'user_id'        => $user->id,
            'atendimento_id' => $this->atendimento->id,
            'comentario'     => $this->novoComentario,
        ]);

        $this->atendimento->increment('comentarios_count');

        // Notifica o voluntário dono se for coordenador comentando
        if ($user->hasRole('editor') || $user->hasRole('super_admin')) {
            $donoPessoa = $this->atendimento->pessoa->user_id;
            if ($donoPessoa !== $user->id) {
                Notificacao::create([
                    'user_id'        => $donoPessoa,
                    'atendimento_id' => $this->atendimento->id,
                    'type'           => 'comentario',
                    'data'           => json_encode([
                        'autor'      => $user->label_comentario,
                        'comentario' => substr($this->novoComentario, 0, 80),
                        'pessoa'     => $this->atendimento->pessoa->nome,
                    ]),
                ]);
            }
        }

        $this->novoComentario = '';
        $this->mostrarComentarios = true;
        $this->atendimento->refresh();
    }

    public function toggleComentarios(): void
    {
        $this->mostrarComentarios = !$this->mostrarComentarios;
    }

    public function render()
    {
        $comentarios = $this->atendimento->comentarios()->with('user')->latest()->get();
        $jaCourtiu   = Curtida::where('user_id', Auth::id())
            ->where('atendimento_id', $this->atendimento->id)
            ->exists();

        return view('livewire.card-atendimento', compact('comentarios', 'jaCourtiu'));
    }
}