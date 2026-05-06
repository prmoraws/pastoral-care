<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nome',
        'foto',
        'endereco',
        'contato',
        'observacoes',
        'atendimentos_count',
    ];

    public function voluntario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function atendimentos()
    {
        return $this->hasMany(Atendimento::class);
    }

    public function ultimoAtendimento()
    {
        return $this->hasOne(Atendimento::class)->latestOfMany();
    }
}