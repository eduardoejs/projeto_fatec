<?php

namespace App\Models\Acl;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password','ativo', 'tipo',
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

    public function perfis() {
        return $this->belongsToMany(Perfil::class);
    }

    public function inscricoes() {
        return $this->belongsToMany(Inscricao::class);
    }

    public function alunos() {
        return $this->hasMany(Aluno::class);
    }

    public function funcionarios() {
        return $this->hasMany(Funcionario::class);
    }

    public function docentes() {
        return $this->hasMany(Docente::class);
    }

    public function convidados() {
        return $this->hasMany(Convidado::class);
    }

    public function avisos() {
        return $this->hasMany(Aviso::class);
    }

    public function agendamentos() {
        return $this->hasMany(Agendamento::class);
    }

    public function noticias() {
        return $this->hasMany(Noticia::class);
    }

    public function destaques() {
        return $this->hasMany(Destaque::class);
    }

    //
    public function temUmPerfilDestes($perfis) {
        $userPerfis = $this->perfis;
        return $perfis->intersect($userPerfis)->count();
    }

    public function existePerfil($perfil) {
        if(is_string($perfil)){
            $perfil = Perfil::where('nome','=',$perfil)->firstOrFail();
        }
        return (boolean) $this->perfis()->find($perfil->id);
    }

    public function isAdmin() {
        return $this->existePerfil('ADMINISTRADOR');
    }
    //

    //Método Acessor
    public function getNameLastnameAttribute() {
        switch ($this->tipo) {
            case 'A':                
                return $this->getNomeSobrenome($this->alunos()->first()->nome);
            break;
            case 'F':                
                return $this->getNomeSobrenome($this->funcionarios()->first()->nome);
            break;
            case 'D':
                return $this->getNomeSobrenome($this->docentes()->first()->nome);    
            
            break; 
            case 'C':
                return $this->getNomeSobrenome($this->convidados()->first()->nome);                
            break;
            default:
                Auth::logout();
            break;
        }
    }

    public function getNameAttribute() {
        switch ($this->tipo) {
            case 'A':                
                return $this->alunos()->first()->nome;
            break;
            case 'F':                
                return $this->funcionarios()->first()->nome;
            break;
            case 'D':
                return $this->docentes()->first()->nome;    
            
            break; 
            case 'C':
                return $this->convidados()->first()->nome;
            break;
            default:
                Auth::logout();
            break;
        }
    }

    private function getNomeSobrenome($nomeCompleto) {
        $partes = explode(' ', $nomeCompleto);
        $primeiroNome = array_shift($partes); //remove e retorna o primeiro valor do array.
        $ultimoNome = array_pop($partes); //remove e retorna o último valor do array.
        return $primeiroNome.' '.$ultimoNome;
    }
}
