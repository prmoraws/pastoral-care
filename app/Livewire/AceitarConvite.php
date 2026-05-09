<?php

namespace App\Livewire;

use App\Models\Convite;
use App\Models\User;
use App\Models\PerfilVoluntario;
use App\Models\PerfilCoordenador;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AceitarConvite extends Component
{
    public Convite $convite;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $contato = '';
    public string $igreja = '';
    public string $condicao = '';
    public string $cargo = '';

    public bool $sucesso = false;

    public function rules(): array
    {
        return [
            'name'                  => 'required|min:2|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'contato'               => 'nullable|max:20',
            'igreja'                => 'nullable|max:255',
            'condicao'              => 'required_if:papel,author',
            'cargo'                 => 'required_if:papel,editor',
        ];
    }

    public function getPapelProperty(): string
    {
        return $this->convite->papel;
    }

    public function registrar(): void
    {
        $this->validate();

        if (!$this->convite->isValido()) {
            $this->addError('email', 'Este convite não é mais válido.');
            return;
        }

        // Criar usuário
        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Atribuir papel
        $user->assignRole($this->convite->papel);

        // Criar perfil específico
        if ($this->convite->papel === 'author') {
            PerfilVoluntario::create([
                'user_id'  => $user->id,
                'condicao' => $this->condicao,
                'contato'  => $this->contato,
                'igreja'   => $this->igreja,
                'ativo'    => true,
            ]);
        } else {
            PerfilCoordenador::create([
                'user_id' => $user->id,
                'cargo'   => $this->cargo,
                'contato' => $this->contato,
                'igreja'  => $this->igreja,
            ]);
        }

        // Marcar convite como usado
        $this->convite->update([
            'usado'    => true,
            'usado_por' => $user->id,
        ]);

        // Login automático
        Auth::login($user);

        $this->sucesso = true;

        $this->redirect(route('feed'));
    }

    public function render()
    {
        return view('livewire.aceitar-convite')
            ->layout('layouts.guest');
    }
}
