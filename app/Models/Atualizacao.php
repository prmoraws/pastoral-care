<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atualizacao extends Model
{
    protected $table = 'atualizacoes';

    protected $fillable = [
        'atendimento_id',
        'user_id',
        'descricao',
        'foto',
        'curtidas_count',
        'comentarios_count',
    ];

    public function assistido()
    {
        return $this->belongsTo(Assistido::class, 'atendimento_id');
    }


    public function voluntario()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name'   => 'Usuário removido',
            'avatar' => null,
        ]);
    }

    public function curtidas()
    {
        return $this->hasMany(AtualizacaoCurtida::class);
    }

    public function comentarios()
    {
        return $this->hasMany(AtualizacaoComentario::class)->latest();
    }
}
