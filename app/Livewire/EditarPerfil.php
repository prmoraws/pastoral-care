<?php

namespace App\Livewire;

use App\Models\PerfilVoluntario;
use App\Models\PerfilCoordenador;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditarPerfil extends Component
{
    use WithFileUploads;

    // Dados do user
    public string $name = '';
    public string $email = '';
    public string $senhaAtual = '';
    public string $novaSenha = '';
    public string $novaSenhaConfirmacao = '';

    // Dados do perfil
    public string $contato = '';
    public string $igreja = '';
    public string $condicao = '';
    public string $cargo = '';
    public $avatar = null;
    public $avatarAtual = null;

    public string $mensagem = '';
    public string $erro = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name  = $user->name;
        $this->email = $user->email;

        if ($user->hasRole('author')) {
            $perfil = PerfilVoluntario::firstOrCreate(['user_id' => $user->id]);
            $this->contato    = $perfil->contato ?? '';
            $this->igreja     = $perfil->igreja ?? '';
            $this->condicao   = $perfil->condicao ?? '';
            $this->avatarAtual = $perfil->avatar;
        } elseif ($user->hasRole('editor')) {
            $perfil = PerfilCoordenador::firstOrCreate(['user_id' => $user->id]);
            $this->contato    = $perfil->contato ?? '';
            $this->igreja     = $perfil->igreja ?? '';
            $this->cargo      = $perfil->cargo ?? '';
            $this->avatarAtual = $perfil->avatar;
        }
    }

    public function salvarPerfil(): void
    {
        $this->validate([
            'name'    => 'required|min:2|max:255',
            'email'   => 'required|email|unique:users,email,' . Auth::id(),
            'contato' => 'nullable|max:20',
            'igreja'  => 'nullable|max:255',
            'avatar'  => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $user->update(['name' => $this->name, 'email' => $this->email]);

        $avatarPath = $this->avatarAtual;
        if ($this->avatar) {
            $avatarPath = $this->avatar->store('avatars', 'public');
        }

        if ($user->hasRole('author')) {
            PerfilVoluntario::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'contato'  => $this->contato,
                    'igreja'   => $this->igreja,
                    'condicao' => $this->condicao,
                    'avatar'   => $avatarPath,
                ]
            );
        } elseif ($user->hasRole('editor')) {
            PerfilCoordenador::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'contato' => $this->contato,
                    'igreja'  => $this->igreja,
                    'cargo'   => $this->cargo,
                    'avatar'  => $avatarPath,
                ]
            );
        }

        $this->avatarAtual = $avatarPath;
        $this->avatar = null;
        $this->mensagem = 'Perfil atualizado com sucesso!';
        $this->erro = '';
    }

    public function alterarSenha(): void
    {
        $this->validate([
            'senhaAtual'           => 'required',
            'novaSenha'            => 'required|min:8|confirmed',
            'novaSenhaConfirmacao' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->senhaAtual, $user->password)) {
            $this->erro = 'Senha atual incorreta.';
            return;
        }

        $user->update(['password' => Hash::make($this->novaSenha)]);

        $this->senhaAtual = '';
        $this->novaSenha = '';
        $this->novaSenhaConfirmacao = '';
        $this->mensagem = 'Senha alterada com sucesso!';
        $this->erro = '';
    }

    public function render()
    {
        return view('livewire.editar-perfil')
            ->layout('layouts.app');
    }
}
