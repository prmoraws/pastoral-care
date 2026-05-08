<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atendimento extends Model
{
    use HasFactory;

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

    // Título automático
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
        return $this->hasMany(Curtida::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class)->latest();
    }

    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class);
    }

    public function curtidoPor(User $user): bool
    {
        return $this->curtidas()->where('user_id', $user->id)->exists();
    }
}