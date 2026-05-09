<?php

namespace App\Livewire;

use App\Models\Atualizacao;
use App\Models\AtualizacaoCurtida;
use App\Models\AtualizacaoComentario;
use App\Models\Notificacao;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CardAtualizacao extends Component
{
    public Atualizacao $atualizacao;
    public string $novoComentario = '';
    public bool $mostrarComentarios = false;
    public ?int $editandoComentarioId = null;
    public string $textoEdicao = '';

    public function curtir(): void
    {
        $user = Auth::user();
        $curtida = AtualizacaoCurtida::where('user_id', $user->id)
            ->where('atualizacao_id', $this->atualizacao->id)
            ->first();

        if ($curtida) {
            $curtida->delete();
            $this->atualizacao->decrement('curtidas_count');
        } else {
            AtualizacaoCurtida::create([
                'user_id'        => $user->id,
                'atualizacao_id' => $this->atualizacao->id,
            ]);
            $this->atualizacao->increment('curtidas_count');
        }
        $this->atualizacao->refresh();
    }

    public function comentar(): void
    {
        $this->validate(['novoComentario' => 'required|min:2|max:500']);
        $user = Auth::user();

        AtualizacaoComentario::create([
            'user_id'        => $user->id,
            'atualizacao_id' => $this->atualizacao->id,
            'comentario'     => $this->novoComentario,
        ]);

        $this->atualizacao->increment('comentarios_count');

        // Notifica voluntário dono
        if ($user->hasRole('editor') || $user->hasRole('super_admin')) {
            $donoVoluntario = $this->atualizacao->user_id;
            if ($donoVoluntario !== $user->id) {
                $nomeAssistido = $this->atualizacao->assistido?->nome_assistido ?? 'assistido';
                Notificacao::create([
                    'user_id'        => $donoVoluntario,
                    'atendimento_id' => $this->atualizacao->atendimento_id,
                    'type'           => 'comentario_atualizacao',
                    'data'           => json_encode([
                        'autor'      => $user->label_comentario,
                        'comentario' => substr($this->novoComentario, 0, 80),
                        'pessoa'     => $nomeAssistido,
                    ]),
                ]);
            }
        }

        $this->novoComentario = '';
        $this->mostrarComentarios = false;
        $this->atualizacao->refresh();
    }

    public function toggleComentarios(): void
    {
        $this->mostrarComentarios = !$this->mostrarComentarios;
        $this->novoComentario = '';
    }

    public function render()
    {
        $comentariosAtualizacao = $this->atualizacao->comentarios()->with('user')->get();
        $jaCourtiu = AtualizacaoCurtida::where('user_id', Auth::id())
            ->where('atualizacao_id', $this->atualizacao->id)
            ->exists();

        return view('livewire.card-atualizacao', [
            'comentarios' => $comentariosAtualizacao,
            'jaCourtiu'   => $jaCourtiu,
        ]);
    }

    public function iniciarEdicao(int $id, string $texto): void
    {
        $this->editandoComentarioId = $id;
        $this->textoEdicao = $texto;
    }

    public function salvarEdicao(): void
    {
        $this->validate(['textoEdicao' => 'required|min:2|max:500']);

        $comentario = \App\Models\AtualizacaoComentario::find($this->editandoComentarioId);

        if ($comentario && $comentario->user_id === Auth::id()) {
            $comentario->update(['comentario' => $this->textoEdicao]);
        }

        $this->editandoComentarioId = null;
        $this->textoEdicao = '';
    }

    public function cancelarEdicao(): void
    {
        $this->editandoComentarioId = null;
        $this->textoEdicao = '';
    }
}
