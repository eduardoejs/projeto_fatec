<?php

namespace App\Models\Sistema\Gerenciamento\Imagens;

use App\Models\Sistema\Eventos\Evento;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Destaques\Destaque;
use App\Models\Sistema\Vestibular\Vestibular;

class Imagem extends Model
{
    protected $table = 'imagens';

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
}
