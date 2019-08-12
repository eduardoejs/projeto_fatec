<?php

namespace App\Models\Institucional\TiposUsuarios;

use App\Models\Acl\User;
use Illuminate\Database\Eloquent\Model;

class Convidado extends Model
{
    protected $fillable = [ 'fone', 'user_id'];

    public function login() 
    {
        return $this->belongsTo(User::class);
    }
}
