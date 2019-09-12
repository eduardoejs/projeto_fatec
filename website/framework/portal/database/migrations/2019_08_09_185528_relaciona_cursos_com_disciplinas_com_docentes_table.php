<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionaCursosComDisciplinasComDocentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_disciplina_docente', function (Blueprint $table) {
            $table->bigInteger('curso_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');

            $table->bigInteger('disciplina_id')->unsigned();
            $table->foreign('disciplina_id')->references('id')->on('disciplinas')->onDelete('cascade');

            $table->bigInteger('docente_id')->unsigned()->nullable();
            $table->foreign('docente_id')->references('user_id')->on('docentes')->onDelete('set null');

            $table->integer('semestre')->unsigned();
            $table->integer('carga_horaria')->unsigned();

            $table->timestamps();

            $table->primary(['curso_id', 'disciplina_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curso_disciplina_docente', function (Blueprint $table) {
            $table->dropForeign('curso_disciplina_docente_docente_id_foreign');
            $table->dropColumn('docente_id');
            $table->dropForeign('curso_disciplina_docente_disciplina_id_foreign');
            $table->dropColumn('disciplina_id');
            $table->dropForeign('curso_disciplina_docente_curso_id_foreign');
            $table->dropColumn('curso_id');            
        });
        Schema::dropIfExists('curso_disciplina_docente');
    }
}
