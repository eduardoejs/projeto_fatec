<?php

namespace App\Models\Sistema\Gerenciamento\Imagens;

use Illuminate\Database\Eloquent\Model;

class ImagemNoticia extends Model
{
    protected $table = 'imagem_noticia';
    protected $fillable = ['noticia_id','imagem_id','titulo','descricao', 'ordem'];
}
