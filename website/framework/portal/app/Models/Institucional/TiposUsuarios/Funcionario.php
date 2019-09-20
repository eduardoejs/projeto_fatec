<?php

namespace App\Models\Institucional\TiposUsuarios;

use App\Models\Acl\User;
use App\Models\Institucional\Cargo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institucional\Departamento;

class Funcionario extends Model
{
    public $incrementing = false; 
    protected $primaryKey = 'user_id';
    
    protected $fillable = ['cargo_id', 'departamento_id', 'user_id'];

    public function user() 
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
