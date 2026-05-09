<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assistido extends Model
{
    use HasFactory;

    protected $table = 'assistidos';

    protected $fillable = [
        'user_id',
        'nome_assistido',
        'contato',
        'endereco',
        'bairro',
        'cidade',
        'foto',
        'imagem',
        'descricao',
        'data_atendimento',
        'ordem',
        'curtidas_count',
        'comentarios_count',
    ];

    protected function casts(): array
    {
        return [
            'data_atendimento' => 'date',
        ];
    }

    public function getTituloAttribute(): string
    {
        $data = $this->data_atendimento->format('d/m/Y');
        return $this->ordem === 1
            ? "Atendimento - {$data}"
            : "Atualização - {$data}";
    }

    public function voluntario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function curtidas()
    {
        return $this->hasMany(Curtida::class, 'atendimento_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'atendimento_id')->latest();
    }

    public function atualizacoes()
    {
        return $this->hasMany(Atualizacao::class, 'atendimento_id')->latest();
    }

    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class, 'atendimento_id');
    }
}