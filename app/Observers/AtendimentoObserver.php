<?php

namespace App\Observers;

use App\Models\Atendimento;

class AtendimentoObserver
{
    public function creating(Atendimento $atendimento): void
    {
        // Define a ordem automaticamente
       $atendimento->ordem = Atendimento::where('user_id', $atendimento->user_id)->count() + 1;

        // Garante que user_id seja o usuário autenticado
        if (empty($atendimento->user_id)) {
            $atendimento->user_id = auth()->id();
        }
    }

    public function created(Atendimento $atendimento): void
    {
        // Incrementa o contador de atendimentos na pessoa
        $atendimento->pessoa()->increment('atendimentos_count');
    }

    public function deleted(Atendimento $atendimento): void
    {
        // Decrementa o contador de atendimentos na pessoa
        $atendimento->pessoa()->decrement('atendimentos_count');
    }
}
