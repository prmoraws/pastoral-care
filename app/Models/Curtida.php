<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curtida extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'atendimento_id'];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name'   => 'Usuário removido',
            'avatar' => null,
        ]);
    }

    public function atendimento()
    {
        return $this->belongsTo(Atendimento::class);
    }
}
