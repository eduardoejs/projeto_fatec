<?php

namespace App\Models\Acl;

use App\Models\Sistema\Avisos;
use App\Models\Sistema\Noticias\Noticia;
use Illuminate\Notifications\Notifiable;
use App\Models\Sistema\Eventos\Inscricao;
use App\Models\Sistema\Destaques\Destaque;
use App\Models\Sistema\Agendamento\Agendamento;
use App\Models\Institucional\TiposUsuarios\Aluno;
use App\Models\Institucional\TiposUsuarios\Docente;
use App\Models\Institucional\TiposUsuarios\Convidado;
use App\Models\Institucional\TiposUsuarios\Funcionario;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'password','ativo', 'tipo', 'cpf', 'sexo', 'telefone', 'url_lattes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function perfis() 
    {
        return $this->belongsToMany(Perfil::class)->withTimestamps();
    }

    public function inscricoes() 
    {
        return $this->belongsToMany(Inscricao::class);
    }

    public function alunos() 
    {
        return $this->hasMany(Aluno::class);
    }

    public function funcionarios() 
    {
        return $this->hasMany(Funcionario::class);
    }

    public function docentes() 
    {
        return $this->hasMany(Docente::class);
    }

    public function convidados() 
    {
        return $this->hasMany(Convidado::class);
    }

    public function avisos() 
    {
        return $this->hasMany(Aviso::class);
    }

    public function agendamentos() 
    {
        return $this->hasMany(Agendamento::class);
    }

    public function noticias() 
    {
        return $this->hasMany(Noticia::class);
    }

    public function destaques() 
    {
        return $this->hasMany(Destaque::class);
    }

    //
    public function temUmPerfilDestes($perfis) 
    {
        $userPerfis = $this->perfis;
        return $perfis->intersect($userPerfis)->count();
    }

    public function existePerfil($perfil) 
    {
        if(is_string($perfil)) {
            $perfil = Perfil::where('nome','=',$perfil)->firstOrFail();
        }
        return (boolean) $this->perfis()->find($perfil->id);
    }

    public function isAdmin() {
        return $this->existePerfil('ADMINISTRADOR');
    }
    //

    //Método Acessor
    public function getNomeAbrAttribute() 
    {
        return $this->getNomeSobrenome($this->nome);
    } 
    
    public function getStatusAttribute()
    {
        $status = '';
        switch($this->ativo) 
        {
            case 'S':
                $status = 'Ativo';
            break;
            case 'N':
                $status = 'Inativo';
            break;
        }
        return $status;
    }

    public function getTipoUserArrayAttribute()
    {
        //recupero os tipos de usuário cadastrado
        $array = explode(',', $this->tipo);
        $arrayTipos = [];
        for($i = 0; $i < count($array); $i++)
        {
            $arrayTipos[$i] = (object)$arrayTipos[$i] = $array[$i];
        }
        return json_decode(str_replace('scalar', 'valor',json_encode($arrayTipos)));        
    }

    public function getTipoUserAttribute() 
    {
        $tipo = '';
        $valor = '';
        $arrayTipos = explode(',', $this->tipo);
        $tipo = '<div class="col-8">';
        foreach ($arrayTipos as $key => $value) {            
            switch ($value) 
            {
                case 'A':
                    $valor = 'Aluno';
                    break;
                case 'D':
                    $valor = 'Docente';
                    break;            
                case 'F':
                    $valor = 'Funcionário';
                    break;
                case 'C':
                    $valor = 'Convidado';
                    break;    
                case 'EX':
                    $valor = 'Ex-Aluno';
                    break;
            }            
            $tipo .= ' <span class="badge badge-dark">'.$valor.'</span> ';
        }
        $tipo .= '</div>';
        return $tipo;
    }

    private function getNomeSobrenome($nomeCompleto) 
    {
        $partes = explode(' ', $nomeCompleto);
        $primeiroNome = array_shift($partes); //remove e retorna o primeiro valor do array.
        $ultimoNome = array_pop($partes); //remove e retorna o último valor do array.
        return $primeiroNome.' '.$ultimoNome;
    }
}
