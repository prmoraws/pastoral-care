<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'cargo',
        'condicao',
        'contato',
        'ativo',
        'registration_token',
        'token_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'registration_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'token_expires_at'  => 'datetime',
            'ativo'             => 'boolean',
            'password'          => 'hashed',
        ];
    }

    // Acesso ao painel Filament
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->ativo;
    }

    // Label do comentário: "Bispo: Fulano"
    public function getLabelComentarioAttribute(): string
    {
        if ($this->cargo) {
            return "{$this->cargo}: {$this->name}";
        }
        return $this->name;
    }

    // Relacionamentos
    public function pessoas()
    {
        return $this->hasMany(Pessoa::class);
    }

    public function atendimentos()
    {
        return $this->hasMany(Atendimento::class);
    }

    public function curtidas()
    {
        return $this->hasMany(Curtida::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class);
    }
}
