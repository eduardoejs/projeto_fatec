<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('nome');
            $table->string('cpf', 14)->unique();            
            $table->enum('sexo', ['M', 'F']);                       
            $table->string('email')->unique();            
            $table->string('password');
            $table->string('telefone', 15)->nullable();
            $table->enum('ativo',['S','N'])->default('S'); // Sim ou Nao
            $table->set('tipo', ['A', 'F', 'D', 'C', 'EX']); //A=Aluno F=Funcionario D=Docente C=Convidado 
            $table->string('url_lattes')->nullable();
            $table->string('token_create', 40)->nullable(); //token usado para validacao quando o usuario for cadastrado, é enviado um email com ele 
            $table->string('token_access')->nullable(); //token usado para verificação de login único
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
