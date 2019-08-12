<?php

namespace App\Models\Sistema\Agendamento;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = ['nome', 'dias_antecedencia'];
    
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
