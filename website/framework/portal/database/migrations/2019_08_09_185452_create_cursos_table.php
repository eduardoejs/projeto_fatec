<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 255);
            $table->integer('duracao');
            $table->longText('conteudo');
            $table->set('periodo', ['M','T','N']);
            $table->integer('qtde_vagas');
            $table->string('email_coordenador', 255)->nullable();
            $table->enum('ativo', ['S','N'])->default('S');

            $table->bigInteger('tipo_curso_id')->unsigned();
            $table->foreign('tipo_curso_id')->references('id')->on('tipo_cursos')->onDelete('cascade');
            
            $table->bigInteger('modalidade_id')->unsigned();
            $table->foreign('modalidade_id')->references('id')->on('modalidades')->onDelete('cascade');
            
            $table->bigInteger('docente_id')->unsigned()->nullable();
            $table->foreign('docente_id')->references('user_id')->on('docentes')->onDelete('set null');

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
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropForeign('cursos_docente_id_foreign');
            $table->dropColumn('docente_id');
            $table->dropForeign('cursos_modalidade_id_foreign');
            $table->dropColumn('modalidade_id');
            $table->dropForeign('cursos_tipo_curso_id_foreign');
            $table->dropColumn('tipo_curso_id');            
        });
        Schema::dropIfExists('curso_disciplina_docente');
        Schema::dropIfExists('cursos');
    }
}
