<?php

namespace App\Models\Acl;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfis';
    protected $fillable = ['nome', 'descricao'];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function permissoes() {
        return $this->belongsToMany(Permissao::class);
    }

    public function paginas() {
        return $this->belongsToMany(Pagina::class);
    }
}
