<?php

namespace App\Models\Acl;

use App\Models\Sistema\Avisos;
use App\Models\Sistema\Noticias\Noticia;
use Illuminate\Notifications\Notifiable;
use App\Models\Sistema\Eventos\Inscricao;
use App\Models\Sistema\Destaques\Destaque;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password','ativo', 'tipo', 'nome', 'cpf', 'sexo',
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
        return $this->belongsToMany(Perfil::class);
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
    
    public function getTipoUserAttribute() 
    {
        $tipo = '';
        switch ($this->tipo) {
            case 'A':
                $tipo = 'Aluno';
                break;
            case 'D':
                $tipo = 'Docente';
                break;            
            case 'F':
                $tipo = 'Funcionário';
                break;
            case 'C':
                $tipo = 'Convidado';
                break;    
            case 'EX':
                $tipo = 'Ex-Aluno';
                break;            
            default:
                $tipo = 'Não atribuído';
                break;
        }
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
