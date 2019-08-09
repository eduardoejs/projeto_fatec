<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubeventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subeventos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 255);
            $table->string('descricao')->nullable();
            $table->string('palestrante')->nullable();
            $table->string('local')->nullable(); //Local onde será realizado o evento. Ex. Lab 01
            $table->integer('total_vagas')->unsigned()->nullable(); //Se NULL não limita as inscricoes
            $table->decimal('valor_inscricao', 8,2)->nullable();
            $table->integer('carga_horaria')->unsigned()->nullable();            
            $table->enum('categoria', ['P', 'M', 'O', 'W'])->default('P'); //Palestra MiniCurso Oficina Workshop
            $table->date('data');
            $table->time('horario_inicio');
            $table->time('horario_fim')->nullable();
            $table->enum('ativo', ['S','N'])->default('S');
            $table->set('publico_alvo', ['A','D','F','C','EX']); //Aluno Docente Funcionario Convidado ExAluno
            $table->set('termo', ['1','2','3','4','5','6'])->default('1','2','3','4','5','6')->nullable();

            $table->bigInteger('curso_evento_id')->unsigned();
            $table->foreign('curso_evento_id')->references('id')->on('curso_evento')->onDelete('cascade');

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
        Schema::table('subeventos', function (Blueprint $table) {
            $table->dropForeign('subeventos_curso_evento_id_foreign');
            $table->dropColumn('curso_evento_id');
        });
        Schema::dropIfExists('subeventos');
    }
}
