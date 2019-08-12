<?php

namespace App\Models\Sistema\TCC;

use App\Models\Cursos\Curso;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institucional\TiposUsuarios\Docente;

class Tcc extends Model
{
    protected $fillable = ['autor1', 'autor2', 'autor3','resumo','palavra_chave','arquivo',
                           'docente_id','curso_id'];

    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
