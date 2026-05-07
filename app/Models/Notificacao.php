<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table = 'notificacoes';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'atendimento_id',
        'type',
        'data',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'data'       => 'array',
            'read_at'    => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function atendimento()
    {
        return $this->belongsTo(Atendimento::class);
    }

    public function marcarComoLida(): void
    {
        $this->update(['read_at' => now()]);
    }
}