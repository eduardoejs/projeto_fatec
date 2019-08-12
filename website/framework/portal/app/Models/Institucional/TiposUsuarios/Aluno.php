<?php

namespace App\Models\Institucional\TiposUsuarios;

use App\Models\Acl\User;
use App\Models\Cursos\Curso;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = ['nome', 'cpf', 'sexo', 'matricula', 'curso_id', 'user_id'];
    
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function curso() 
    {
        return $this->belongsTo(Curso::class);
    }
}
