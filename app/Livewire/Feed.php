<?php

namespace App\Livewire;

use App\Models\Assistido;
use App\Models\User;
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
    protected $listeners = ['atendimento-criado' => '$refresh'];

    public function updatingBusca(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();

        $assistidos = Assistido::query()
            ->with(['voluntario.perfilVoluntario', 'curtidas', 'comentarios.user', 'atualizacoes'])
            ->when($user->hasRole('author'), fn($q) => $q->where('user_id', $user->id))
            ->when($this->busca, fn($q) => $q->where('nome_assistido', 'like', "%{$this->busca}%"))
            ->when($this->filtroVoluntario, fn($q) => $q->where('user_id', $this->filtroVoluntario))
            ->when($this->filtroData, fn($q) => $q->whereDate('data_atendimento', $this->filtroData))
            ->latest()
            ->paginate(10);

        $voluntarios = User::role('author')->pluck('name', 'id');

        return view('livewire.feed', compact('assistidos', 'voluntarios'))
            ->layout('layouts.app');
    }
}