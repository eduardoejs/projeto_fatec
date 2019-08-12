<?php

namespace App\Models\Institucional;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = ['nome', 'email'];

    public function funcionario() 
    {
        return $this->hasOne(Funcionario::class);
    }
}
