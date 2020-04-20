<?php

namespace App\Models\Sistema\Avisos;

use Carbon\Carbon;
use App\Models\Acl\User;
use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    protected $fillable = ['titulo', 'resumo', 'conteudo', 'data_exibicao', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getExibirAteDataAttribute() 
    {
        return Carbon::parse($this->data_exibicao)->format('d/m/Y');
    } 
    
    public function getDataCriacaoAttribute() 
    {
        return Carbon::parse($this->created_at)->format('d/m/Y');
    } 
}
