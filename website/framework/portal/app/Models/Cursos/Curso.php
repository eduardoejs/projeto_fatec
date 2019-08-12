<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institucional\TiposUsuarios\Aluno;
use App\Models\Institucional\TiposUsuarios\Docente;

class Curso extends Model
{
    protected $fillable = ['nome', 'duracao', 'conteudo', 'periodo', 'qtde_vagas',
                           'email_coordenador', 'ativo', 
                           'tipo_curso_id', 'modalidade_id', 'docente_id'];

    public function tipoCurso() 
    {
        return $this->belongsTo(TipoCurso::class);
    }

    public function modalidade() 
    {
        return $this->belongsTo(Modalidade::class);
    }

    public function docente() 
    {
        return $this->belongsTo(Docente::class);
    } 

    public function disciplinas() 
    {
        return $this->belongsToMany(Disciplina::class, 'curso_disciplina_docente', 'curso_id', 'disciplina_id')
                    ->withPivot('semestre','carga_horaria','docente_id');
    }

    /*public function tcc() {
        return $this->belongsTo(Docente::class);
    } 
   */    
    public function alunos() 
    {
        return $this->hasMany(Aluno::class);
    }
}
