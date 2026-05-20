<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regiao extends Model
{
    protected $fillable = ['nome', 'bloco_id'];

    public function bloco()
    {
        return $this->belongsTo(Bloco::class);
    }

    public function igrejas()
    {
        return $this->hasMany(Igreja::class);
    }
}