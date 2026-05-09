<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilCoordenador extends Model
{
    protected $table = 'perfil_coordenadores';

    protected $fillable = [
        'user_id',
        'cargo',
        'contato',
        'avatar',
        'igreja',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLabelComentarioAttribute(): string
    {
        if ($this->cargo) {
            return "{$this->cargo}: {$this->user->name}";
        }
        return $this->user->name;
    }
}