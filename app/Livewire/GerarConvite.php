<?php

namespace App\Livewire;

use App\Models\Convite;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class GerarConvite extends Component
{
    public string $papel = '';
    public ?string $linkGerado = null;
    public bool $copiado = false;

    public function rules(): array
    {
        return [
            'papel' => 'required|in:editor,author',
        ];
    }

    public function mount(): void
    {
        $user = Auth::user();
        // Coordenador só pode convidar voluntários
        if ($user->hasRole('editor')) {
            $this->papel = 'author';
        }
    }

    public function gerar(): void
    {
        $this->validate();

        $user = Auth::user();

        // Coordenador só pode convidar voluntários
        if ($user->hasRole('editor') && $this->papel !== 'author') {
            $this->addError('papel', 'Coordenadores só podem convidar voluntários.');
            return;
        }

        $convite = Convite::gerar(Auth::id(), $this->papel);
        $this->linkGerado = $convite->link;
        $this->copiado = false;
    }

    public function novoLink(): void
    {
        $this->linkGerado = null;
        $this->copiado = false;
    }

    public function render()
    {
        $user = Auth::user();
        $convites = Convite::where('criado_por', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.gerar-convite', compact('convites'))
            ->layout('layouts.app');
    }
}
