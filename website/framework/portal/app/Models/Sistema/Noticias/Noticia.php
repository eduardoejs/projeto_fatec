<?php

namespace App\Models\Sistema\Noticias;

use App\Models\Acl\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Gerenciamento\Arquivos\Arquivo;

class Noticia extends Model
{
    protected $fillable = ['titulo','conteudo','data_exibicao','ativo','user_id'];

    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function arquivos()
    {
        return $this->belongsToMany(Arquivo::clas);
    }
}
