<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'atendimento_id', 'comentario'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name'   => 'Usuário removido',
            'avatar' => null,
        ]);
    }

    public function atendimento()
    {
        return $this->belongsTo(Atendimento::class);
    }

    // Label automático para exibição: "Bispo: Fulano"
    public function getAutorLabelAttribute(): string
    {
        return $this->user->label_comentario;
    }
}
