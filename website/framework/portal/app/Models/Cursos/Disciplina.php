<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institucional\TiposUsuarios\Docente;

class Disciplina extends Model
{
    protected $fillable = ['nome'];

    public function cursos() 
    {
        return $this->belongsToMany(Curso::class, 'curso_disciplina_docente', 'disciplina_id', 'curso_id')
                ->withPivot(['semestre','carga_horaria','docente_id']);
    }

    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'curso_disciplina_docente', 'disciplina_id', 'docente_id')
                ->withPivot(['semestre','carga_horaria','docente_id']);
    }
}
