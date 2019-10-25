<?php

namespace App\Models\Sistema\Noticias;

use App\Models\Acl\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Gerenciamento\Imagens\Imagem;
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
        return $this->belongsToMany(Arquivo::class);
    }

    public function imagens()
    {
        return $this->belongsToMany(Imagem::class, 'imagem_noticia', 'noticia_id', 'imagem_id')->withPivot('ordem')->withTimestamps();
    }

    public function getExibirAttribute()
    {   
        if(isset($this->data_exibicao)) {
            return date('d/m/Y', strtotime(str_replace("/", "-", $this->data_exibicao)));
        } else {
            return '-';
        }        
    }

    public function getStatusAttribute()
    {
        $status = '';
        switch($this->ativo) 
        {
            case 'S':
                $status = 'SIM';
            break;
            case 'N':
                $status = 'NÃO';
            break;
        }
        return $status;
    }

    public function getConteudoResumidoAttribute()
    {
        return str_limit($this->getAttribute('conteudo'), 405, '...');
    }
}
