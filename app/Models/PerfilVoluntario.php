<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilVoluntario extends Model
{
    protected $table = 'perfil_voluntarios';

    protected $fillable = [
        'user_id',
        'condicao',
        'contato',
        'avatar',
        'igreja',
        'ativo',
        'registration_token',
        'token_expires_at',
    ];

    protected function casts(): array
    {
        return [
            'ativo'            => 'boolean',
            'token_expires_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assistidos()
    {
        return $this->hasMany(Assistido::class, 'user_id', 'user_id');
    }
}