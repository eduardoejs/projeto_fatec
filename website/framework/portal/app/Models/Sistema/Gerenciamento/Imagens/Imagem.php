<?php

namespace App\Models\Sistema\Gerenciamento\Imagens;

use App\Models\Sistema\Eventos\Evento;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Noticias\Noticia;
use App\Models\Sistema\Destaques\Destaque;
use App\Models\Sistema\Vestibular\Vestibular;

class Imagem extends Model
{
    protected $table = 'imagens';
    protected $fillable = ['titulo', 'descricao', 'nome_arquivo', 'tamanho_arquivo'];

    public function vestibular()
    {
        return $this->belongsTo(Vestibular::class);
    }

    public function destaque()
    {
        return $this->belongsTo(Destaque::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }   
    
    public function noticias()
    {
        return $this->belongsToMany(Noticia::class, 'imagem_noticia', 'imagem_id', 'noticia_id')->withPivot('ordem')->withTimestamps();
    }
}
