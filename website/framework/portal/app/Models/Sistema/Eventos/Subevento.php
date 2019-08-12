<?php

namespace App\Models\Sistema\Eventos;

use Illuminate\Database\Eloquent\Model;

class Subevento extends Model
{
    protected $fillable = ['nome', 'descricao', 'palestrante','local','total_vagas',
                           'valor_inscricao','carga_horaria','categoria','data','horario_inicio',
                           'horario_fim','ativo','publico_alvo','termo','curso_evento_id'];
}
