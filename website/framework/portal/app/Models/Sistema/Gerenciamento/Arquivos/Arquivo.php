<?php

namespace App\Models\Sistema\Gerenciamento\Arquivos;

use App\Models\Cursos\Curso;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Noticias\Noticia;
use App\Models\Sistema\Vestibular\Vestibular;

class Arquivo extends Model
{
    protected $fillable = ['titulo', 'descricao', 'tamanho_arquivo', 'nome_arquivo'];

    public function vestibulares()
    {
        return $this->belongsToMany(Vestibular::class);
    }

    public function noticias()
    {
        return $this->belongsToMany(Noticia::class);
    }

    public function cursos()
    {
        return $this->belongsToMany(Curso::class);
    }
}
