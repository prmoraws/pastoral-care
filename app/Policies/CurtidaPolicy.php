<?php

namespace App\Policies;

use App\Models\Curtida;
use App\Models\User;

class CurtidaPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->hasRole('super_admin')) return true;
        return null;
    }

    // Coordenador e voluntário dono podem curtir
    public function create(User $user): bool
    {
        return true; // validação de acesso feita no controller
    }

    // Apenas quem curtiu pode descurtir
    public function delete(User $user, Curtida $curtida): bool
    {
        return $curtida->user_id === $user->id;
    }
}
