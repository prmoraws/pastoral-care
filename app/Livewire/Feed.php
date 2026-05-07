<?php

namespace App\Livewire;

use App\Models\Pessoa;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Feed extends Component
{
    use WithPagination;

    public string $busca = '';
    public string $filtroVoluntario = '';
    public string $filtroData = '';

    protected $queryString = ['busca', 'filtroVoluntario', 'filtroData'];

    public function updatingBusca(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();

        $pessoas = Pessoa::query()
            ->with(['voluntario', 'atendimentos' => fn($q) => $q->latest('data_atendimento')])
            ->when($user->hasRole('author'), fn($q) => $q->where('user_id', $user->id))
            ->when($this->busca, fn($q) => $q->where('nome', 'like', "%{$this->busca}%"))
            ->when($this->filtroVoluntario, fn($q) => $q->where('user_id', $this->filtroVoluntario))
            ->when($this->filtroData, fn($q) => $q->whereHas('atendimentos', fn($a) =>
                $a->whereDate('data_atendimento', $this->filtroData)
            ))
            ->orderByDesc(
                \App\Models\Atendimento::select('created_at')
                    ->whereColumn('pessoa_id', 'pessoas.id')
                    ->latest()
                    ->limit(1)
            )
            ->paginate(10);

        $voluntarios = \App\Models\User::role('author')->where('ativo', true)->pluck('name', 'id');

        return view('livewire.feed', compact('pessoas', 'voluntarios'))
            ->layout('layouts.app');
    }
}