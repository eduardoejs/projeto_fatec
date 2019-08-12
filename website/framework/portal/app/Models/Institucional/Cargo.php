<?php

namespace App\Models\Institucional;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = ['nome'];

    public function funcionario() 
    {
        return $this->hasOne(Funcionario::class);
    }
}
