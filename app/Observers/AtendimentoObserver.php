<?php

namespace App\Observers;

use App\Models\Assistido;

class AtendimentoObserver
{
    public function creating(Assistido $assistido): void
    {
        $assistido->ordem = Assistido::where('user_id', $assistido->user_id)->count() + 1;

        if (empty($assistido->user_id)) {
            $assistido->user_id = auth()->id();
        }
    }
}