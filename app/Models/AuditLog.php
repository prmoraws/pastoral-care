<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLog extends Model
{
    public $timestamps = false;
    public $updatedAt = false;

    protected $table = 'audit_logs';

    protected $fillable = [
        'user_id',
        'acao',
        'modelo',
        'modelo_id',
        'dados_anteriores',
        'dados_novos',
    ];

    protected function casts(): array
    {
        return [
            'dados_anteriores' => 'array',
            'dados_novos'      => 'array',
            'created_at'       => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function registrar(string $acao, Model $modelo, array $dadosAnteriores = [], array $dadosNovos = []): void
    {
        static::create([
            'user_id'          => Auth::id(),
            'acao'             => $acao,
            'modelo'           => class_basename($modelo),
            'modelo_id'        => $modelo->id,
            'dados_anteriores' => $dadosAnteriores ?: null,
            'dados_novos'      => $dadosNovos ?: null,
        ]);
    }
}
