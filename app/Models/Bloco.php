<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloco extends Model
{
    protected $fillable = ['nome'];

    public function regiaos()
    {
        return $this->hasMany(Regiao::class);
    }
}