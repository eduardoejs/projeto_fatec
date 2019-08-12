<?php

namespace App\Models\Sistema\Gerenciamento\Arquivos;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Noticias\Noticia;
use App\Models\Sistema\Vestibular\Vestibular;

class Arquivo extends Model
{
    protected $fillable = ['titulo', 'descricao', 'url_armazenamento', 'tamanho_arquivo'];

    public function vestibulares()
    {
        return $this->belongsToMany(Vestibular::clas);
    }

    public function noticias()
    {
        return $this->belongsToMany(Noticia::clas);
    }
}
