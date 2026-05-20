<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Igreja extends Model
{
    protected $fillable = ['nome', 'regiao_id'];

    public function regiao()
    {
        return $this->belongsTo(Regiao::class);
    }
}