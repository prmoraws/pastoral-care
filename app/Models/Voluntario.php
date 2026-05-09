<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voluntario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'voluntarios';

    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'igreja',
        'condicao',
        'foto',
        'endereco',
        'contato',
        'atendimentos_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function atendimentos()
    {
        return $this->hasMany(Atendimento::class, 'user_id', 'user_id');
    }
}