<?php

namespace App\Policies;

use App\Models\Atendimento;
use App\Models\User;

class AtendimentoPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->hasRole('super_admin')) return true;
        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Atendimento $atendimento): bool
    {
        return $user->hasRole('editor') || $atendimento->pessoa->user_id === $user->id;
    }

    // Apenas o voluntário dono da pessoa pode criar
    public function create(User $user): bool
    {
        return true; // validação do user_id feita no controller
    }

    // Apenas o voluntário que criou pode editar
    public function update(User $user, Atendimento $atendimento): bool
    {
        return $atendimento->user_id === $user->id;
    }

    // Apenas o voluntário que criou pode excluir
    public function delete(User $user, Atendimento $atendimento): bool
    {
        return $atendimento->user_id === $user->id;
    }
}
