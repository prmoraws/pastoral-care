<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtualizacaoCurtida extends Model
{
    protected $table = 'atualizacao_curtidas';
    public $timestamps = false;

    protected $fillable = ['user_id', 'atualizacao_id'];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function atualizacao()
    {
        return $this->belongsTo(Atualizacao::class);
    }
}