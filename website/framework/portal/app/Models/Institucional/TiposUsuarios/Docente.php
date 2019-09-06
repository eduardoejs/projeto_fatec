<?php

namespace App\Models\Institucional\TiposUsuarios;

use App\Models\Acl\User;
use App\Models\Cursos\Curso;
use App\Models\Cursos\Disciplina;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = ['titulacao',
                           'url_lattes', 'link_compartilhado', 'exibe_dados', 'user_id', 
                           'cargo_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    } 
        
    public function curso() 
    {
        return $this->hasOne(Curso::class);
    }

    public function disciplinas() 
    {
        return $this->belongsToMany(Disciplina::class, 'curso_disciplina_docente', 'docente_id', 'disciplina_id')
                    ->withPivot(['semestre','carga_horaria','docente_id']);
    }

    /*public function tcc()
    {
        return $this->belongsTo(Tcc::class);
    } */
}
