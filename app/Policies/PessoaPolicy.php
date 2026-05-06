<?php

namespace App\Policies;

use App\Models\Pessoa;
use App\Models\User;

class PessoaPolicy
{
    // Super Admin tem acesso irrestrito (tratado pelo Shield)
    public function before(User $user): ?bool
    {
        if ($user->hasRole('super_admin')) return true;
        return null;
    }

    // Coordenador vê todos, voluntário só os seus
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Pessoa $pessoa): bool
    {
        return $user->hasRole('editor') || $pessoa->user_id === $user->id;
    }

    // Ambos podem criar
    public function create(User $user): bool
    {
        return true;
    }

    // Coordenador edita qualquer um, voluntário só os seus
    public function update(User $user, Pessoa $pessoa): bool
    {
        return $user->hasRole('editor') || $pessoa->user_id === $user->id;
    }

    // Apenas coordenador pode excluir
    public function delete(User $user, Pessoa $pessoa): bool
    {
        return $user->hasRole('editor');
    }

    // Apenas coordenador pode restaurar
    public function restore(User $user, Pessoa $pessoa): bool
    {
        return $user->hasRole('editor');
    }

    // Coordenador pode reatribuir (alterar user_id)
    public function reassign(User $user): bool
    {
        return $user->hasRole('editor');
    }
}
