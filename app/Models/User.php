<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use App\Models\PerfilCoordenador;
use App\Models\PerfilVoluntario;
use App\Models\Assistido;

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
        return $this->ativo && !$this->hasRole('author');
    }

    // Label do comentário: "Bispo: Fulano"
    public function getLabelComentarioAttribute(): string
    {
        if ($this->hasRole('editor') && $this->perfilCoordenador?->cargo) {
            return "{$this->perfilCoordenador->cargo}: {$this->name}";
        }
        return $this->name;
    }

    // Relacionamentos
    public function perfilCoordenador()
    {
        return $this->hasOne(PerfilCoordenador::class);
    }

    public function perfilVoluntario()
    {
        return $this->hasOne(PerfilVoluntario::class);
    }

    public function assistidos()
    {
        return $this->hasMany(Assistido::class);
    }

    public function atendimentos()
    {
        return $this->hasMany(Assistido::class);
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
