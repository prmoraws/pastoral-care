<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Convite extends Model
{
    protected $fillable = [
        'criado_por',
        'token',
        'papel',
        'usado',
        'usado_por',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'usado'      => 'boolean',
            'expires_at' => 'datetime',
        ];
    }

    public function criador()
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    public function usuadoPor()
    {
        return $this->belongsTo(User::class, 'usado_por');
    }

    public function isValido(): bool
    {
        return !$this->usado && $this->expires_at->isFuture();
    }

    public static function gerar(int $criadoPor, string $papel): self
    {
        return self::create([
            'criado_por' => $criadoPor,
            'token'      => Str::random(48),
            'papel'      => $papel,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public function getLinkAttribute(): string
    {
        return route('convite.aceitar', $this->token);
    }
}