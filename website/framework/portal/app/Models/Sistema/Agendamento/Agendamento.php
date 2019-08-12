<?php

namespace App\Models\Sistema\Agendamento;

use App\Models\Acl\User;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = ['data', 'termo', 'turno', 'tipo', 'aula1', 'aula2', 'aula3', 'aula4', 
                           'aula5', 'horario_inicial', 'horario_final', 'agenda_id', 'user_id'];

    //Relacionamentos
   public function agenda()
   {
       return $this->belongsTo(Agenda::class);
   }

   public function user()
   {
       return $this->belongsTo(User::class);
   }
}
