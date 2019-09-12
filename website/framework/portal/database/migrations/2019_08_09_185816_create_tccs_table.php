<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tccs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('autor1', 255);
            $table->string('autor2', 255)->nullable();
            $table->string('autor3', 255)->nullable();
            $table->longText('resumo');
            $table->string('palavra_chave', 255)->nullable();
            $table->string('arquivo', 255); //URL do arquivo a ser enviado

            $table->bigInteger('docente_id')->unsigned(); //orientador
            $table->foreign('docente_id')->references('user_id')->on('docentes')->onDelete('cascade');

            $table->bigInteger('curso_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');

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
        Schema::table('tccs', function (Blueprint $table) {
            $table->dropForeign('tccs_curso_id_foreign');
            $table->dropColumn('curso_id');
            $table->dropForeign('tccs_docente_id_foreign');
            $table->dropColumn('docente_id');
        });
        Schema::dropIfExists('tccs');
    }
}
