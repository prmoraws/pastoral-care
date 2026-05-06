<?php

namespace App\Policies;

use App\Models\Comentario;
use App\Models\User;

class ComentarioPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->hasRole('super_admin')) return true;
        return null;
    }

    // Coordenador e voluntário dono podem comentar
    public function create(User $user): bool
    {
        return true; // validação de acesso à pessoa feita no controller
    }

    // Apenas quem criou pode editar
    public function update(User $user, Comentario $comentario): bool
    {
        return $comentario->user_id === $user->id;
    }

    // Quem criou ou coordenador pode excluir
    public function delete(User $user, Comentario $comentario): bool
    {
        return $comentario->user_id === $user->id || $user->hasRole('editor');
    }
}
