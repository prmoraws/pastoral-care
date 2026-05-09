<?php

namespace App\Livewire;

use App\Models\Assistido;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class NovoAtendimento extends Component
{
    use WithFileUploads;

    public bool $aberto = false;
    public string $nome_assistido = '';
    public string $contato = '';
    public string $endereco = '';
    public string $bairro = '';
    public string $cidade = '';
    public string $data_atendimento = '';
    public string $descricao = '';
    public $foto = null;
    public $imagem = null;

    protected function rules(): array
    {
        return [
            'nome_assistido'   => 'required|min:2|max:255',
            'contato'          => 'required|max:20',
            'endereco'         => 'required|max:255',
            'bairro'           => 'required|max:100',
            'cidade'           => 'required|max:100',
            'data_atendimento' => 'required|date',
            'descricao'        => 'required|min:2',
            'foto'             => 'nullable|image|max:2048',
            'imagem'           => 'nullable|image|max:2048',
        ];
    }

    public function salvar(): void
    {
        $this->validate();

        $foto   = $this->foto   ? $this->foto->store('assistidos', 'public')    : null;
        $imagem = $this->imagem ? $this->imagem->store('atendimentos', 'public') : null;

        Assistido::create([
            'user_id'          => Auth::id(),
            'nome_assistido'   => $this->nome_assistido,
            'contato'          => $this->contato,
            'endereco'         => $this->endereco,
            'bairro'           => $this->bairro,
            'cidade'           => $this->cidade,
            'data_atendimento' => $this->data_atendimento,
            'descricao'        => $this->descricao,
            'foto'             => $foto,
            'imagem'           => $imagem,
        ]);

        $this->reset(['nome_assistido', 'contato', 'endereco', 'bairro', 'cidade', 'data_atendimento', 'descricao', 'foto', 'imagem']);
        $this->aberto = false;
        $this->dispatch('atendimento-criado');
    }

    public function render()
    {
        return view('livewire.novo-atendimento');
    }
}
