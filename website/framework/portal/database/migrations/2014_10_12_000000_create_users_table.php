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
            $table->string('cpf', 11)->unique();            
            $table->enum('sexo', ['M', 'F']);                       
            $table->string('email')->unique();            
            $table->string('password');
            $table->string('telefone', 15)->nullable();
            $table->enum('ativo',['S','N'])->default('S'); // Sim ou Nao
            $table->enum('tipo', ['A', 'F', 'D', 'C', 'EX']); //A=Aluno F=Funcionario D=Docente C=Convidado EX=ExAluno
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
