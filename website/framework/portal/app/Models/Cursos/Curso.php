<?php

namespace App\Models\Cursos;

use App\Models\Acl\User;
use App\Models\Cursos\Modalidade;
use Illuminate\Support\Facades\DB;
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

    public function getCoordenador($id)
    {
        return $result = User::join('docentes', 'docentes.user_id', '=', 'users.id')
                               ->join('cursos', 'cursos.docente_id', '=', 'docentes.user_id')
                               ->select('users.nome')
                               ->where('cursos.id', '=', $id)
                               ->getQuery()
                               ->get();
    }

    public function getTipoCursoMenu($id)
    {
        $tipo = TipoCurso::findOrFail($id);
        return $result = \DB::table('cursos')
                              ->join('tipo_cursos', 'tipo_cursos.id', '=', 'cursos.tipo_curso_id')
                              ->join('modalidades', 'modalidades.id', '=', 'cursos.modalidade_id')
                              ->select('tipo_cursos.id', 'tipo_cursos.descricao')
                              ->where('tipo_cursos.id', '=', $tipo->id)
                              ->groupBy('tipo_cursos.id')                              
                              ->get();
    }

    public function getModalidadesCursoMenu($id)
    {
        $tipo = TipoCurso::findOrFail($id);
        return $result = \DB::table('cursos')
                              ->join('tipo_cursos', 'tipo_cursos.id', '=', 'cursos.tipo_curso_id')
                              ->join('modalidades', 'modalidades.id', '=', 'cursos.modalidade_id')
                              ->select('modalidades.id', 'modalidades.descricao')
                              ->where('tipo_cursos.id', '=', $tipo->id)
                              ->groupBy('modalidades.id')                              
                              ->get();
    }

    public function getCursosMenu($idTipo, $idModalidade)
    {
        $tipo = TipoCurso::findOrFail($idTipo);
        $modalidade = Modalidade::findOrFail($idModalidade);
        return $result = $this->join('tipo_cursos', 'tipo_cursos.id', '=', 'cursos.tipo_curso_id')
                              ->join('modalidades', 'modalidades.id', '=', 'cursos.modalidade_id')
                              ->select('cursos.id', 'cursos.nome')
                              ->where('tipo_cursos.id', '=', $tipo->id)
                              ->where('modalidades.id', '=', $modalidade->id)
                              ->getQuery()
                              ->get();
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
