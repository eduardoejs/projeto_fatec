<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class TipoCurso extends Model
{
    protected $fillable = ['descricao'];

    public function cursos() 
    {
        return $this->hasMany(Curso::class);
    }
}
