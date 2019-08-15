<?php

namespace App\Models\Acl;

use App\Models\Sistema\Paginas\Pagina;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfis';
    protected $fillable = ['nome', 'descricao'];

    public function users() 
    {
        return $this->belongsToMany(User::class);
    }

    public function permissoes() 
    {
        return $this->belongsToMany(Permissao::class);
    }

    public function paginas() 
    {
        return $this->belongsToMany(Pagina::class);
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = strtoupper($value);
    }
}
