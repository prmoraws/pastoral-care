<?php

namespace App\Livewire;

use App\Models\Assistido;
use App\Models\Atualizacao;
use App\Models\Comentario;
use App\Models\Curtida;
use App\Models\Notificacao;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CardAtendimento extends Component
{
    use WithFileUploads;

    public Assistido $atendimento;
    public string $novoComentario = '';
    public bool $mostrarComentarios = false;
    public bool $mostrarAtualizacao = false;
    public string $descricaoAtualizacao = '';
    public $fotoAtualizacao = null;

    // Edição de comentário
    public ?int $editandoComentarioId = null;
    public string $textoEdicao = '';

    public function curtir(): void
    {
        $user = Auth::user();
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

        Comentario::create([
            'user_id'        => $user->id,
            'atendimento_id' => $this->atendimento->id,
            'comentario'     => $this->novoComentario,
        ]);

        $this->atendimento->increment('comentarios_count');

        if ($user->hasRole('editor') || $user->hasRole('super_admin')) {
            $donoVoluntario = $this->atendimento->user_id;
            if ($donoVoluntario !== $user->id) {
                Notificacao::create([
                    'user_id'        => $donoVoluntario,
                    'atendimento_id' => $this->atendimento->id,
                    'type'           => 'comentario',
                    'data'           => json_encode([
                        'autor'      => $user->label_comentario,
                        'comentario' => substr($this->novoComentario, 0, 80),
                        'pessoa'     => $this->atendimento->nome_assistido,
                    ]),
                ]);
            }
        }

        $this->novoComentario = '';
        $this->mostrarComentarios = false;
        $this->atendimento->refresh();
    }

    public function iniciarEdicao(int $id, string $texto): void
    {
        $this->editandoComentarioId = $id;
        $this->textoEdicao = $texto;
    }

    public function salvarEdicao(): void
    {
        $this->validate(['textoEdicao' => 'required|min:2|max:500']);

        $comentario = Comentario::find($this->editandoComentarioId);

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

    public function registrarAtualizacao(): void
    {
        $this->validate([
            'descricaoAtualizacao' => 'required|min:2|max:1000',
            'fotoAtualizacao'      => 'nullable|image|max:2048',
        ]);

        $foto = null;
        if ($this->fotoAtualizacao) {
            $foto = $this->fotoAtualizacao->store('atualizacoes', 'public');
        }

        Atualizacao::create([
            'atendimento_id' => $this->atendimento->id,
            'user_id'        => Auth::id(),
            'descricao'      => $this->descricaoAtualizacao,
            'foto'           => $foto,
        ]);

        $this->descricaoAtualizacao = '';
        $this->fotoAtualizacao = null;
        $this->mostrarAtualizacao = false;
        $this->atendimento->refresh();
    }

    public function toggleComentarios(): void
    {
        $this->mostrarComentarios = !$this->mostrarComentarios;
        $this->novoComentario = '';
        $this->editandoComentarioId = null;
    }

    public function toggleAtualizacao(): void
    {
        $this->mostrarAtualizacao = !$this->mostrarAtualizacao;
    }

    public function render()
    {
        $comentarios  = $this->atendimento->comentarios()->with('user')->latest()->get();
        $atualizacoes = $this->atendimento->atualizacoes()->with('voluntario')->get();
        $jaCourtiu    = Curtida::where('user_id', Auth::id())
            ->where('atendimento_id', $this->atendimento->id)
            ->exists();
        $ehDono = $this->atendimento->user_id === Auth::id();

        return view('livewire.card-atendimento', compact('comentarios', 'atualizacoes', 'jaCourtiu', 'ehDono'));
    }
}
