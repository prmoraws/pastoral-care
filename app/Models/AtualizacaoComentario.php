<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtualizacaoComentario extends Model
{
    protected $table = 'atualizacao_comentarios';

    protected $fillable = ['user_id', 'atualizacao_id', 'comentario'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name'   => 'Usuário removido',
            'avatar' => null,
        ]);
    }

    public function atualizacao()
    {
        return $this->belongsTo(Atualizacao::class);
    }

    public function getAutorLabelAttribute(): string
    {
        return $this->user->label_comentario;
    }
}
