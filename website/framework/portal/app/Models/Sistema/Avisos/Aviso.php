<?php

namespace App\Models\Sistema\Avisos;

use App\Models\Acl\User;
use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    protected $fillable = ['titulo', 'resumo', 'conteudo', 'data_exibicao', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
