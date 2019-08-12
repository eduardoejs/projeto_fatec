<?php

namespace App\Models\Institucional\TiposUsuarios;

use App\Models\Acl\User;
use App\Models\Institucional\Cargo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institucional\Departamento;

class Funcionario extends Model
{
    protected $fillable = ['url_lattes', 'exibe_dados', 
                           'cargo_id', 'departamento_id', 'user_id'];

    public function login() 
    {
        return $this->belongsTo(User::class);
    }

    public function departamento() 
    {
        return $this->belongsTo(Departamento::class);
    }

    public function cargo() 
    {
        return $this->belongsTo(Cargo::class);
    }
}
