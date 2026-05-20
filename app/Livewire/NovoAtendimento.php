<?php

namespace App\Livewire;

use App\Models\Assistido;
use App\Models\Bloco;
use App\Models\Regiao;
use App\Models\Igreja;
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

    // Cascata
    public ?int $bloco_id = null;
    public ?int $regiao_id = null;
    public ?int $igreja_id = null;

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
            'bloco_id'         => 'nullable|exists:blocos,id',
            'regiao_id'        => 'nullable|exists:regiaos,id',
            'igreja_id'        => 'nullable|exists:igrejas,id',
            'foto'             => 'nullable|image|max:2048',
            'imagem'           => 'nullable|image|max:2048',
        ];
    }

    public function updatedBlocoId(): void
    {
        $this->regiao_id = null;
        $this->igreja_id = null;
    }

    public function updatedRegiaoId(): void
    {
        $this->igreja_id = null;
    }

    public function getRegioesProperty()
    {
        if (!$this->bloco_id) return collect();
        return Regiao::where('bloco_id', $this->bloco_id)->orderBy('nome')->get();
    }

    public function getIgrejasProperty()
    {
        if (!$this->regiao_id) return collect();
        return Igreja::where('regiao_id', $this->regiao_id)->orderBy('nome')->get();
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
            'bloco_id'         => $this->bloco_id,
            'regiao_id'        => $this->regiao_id,
            'igreja_id'        => $this->igreja_id,
            'foto'             => $foto,
            'imagem'           => $imagem,
        ]);

        $this->reset([
            'nome_assistido',
            'contato',
            'endereco',
            'bairro',
            'cidade',
            'data_atendimento',
            'descricao',
            'foto',
            'imagem',
            'bloco_id',
            'regiao_id',
            'igreja_id'
        ]);
        $this->aberto = false;
        $this->dispatch('atendimento-criado');
    }

    public function render()
    {
        return view('livewire.novo-atendimento');
    }
}
