<?php

namespace App\Mail;

use App\Models\Acl\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToNewUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user;    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        // return $this->subject('Bem vindo')->view('emails.newuser')->with([
        //                                             'nome' => $this->user->nome, 
        //                                             'email' => $this->user->email,
        //                                             'token' => $this->user->token,
        //                                             'cpf' => $this->user->cpf,
        //                                         ]);
        return $this->subject('Bem vindo ao portal da Fatec Marília')->markdown('emails.user.created')->with([
                                                        'nome' => $this->user->nome, 
                                                        'email' => $this->user->email,
                                                        'token' => $this->user->token_create,
                                                        'cpf' => $this->user->cpf,
                                                         ]);
               
    }
}
