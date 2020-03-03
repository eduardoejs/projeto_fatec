<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionaArquivoComCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivo_curso', function (Blueprint $table) {
            $table->bigInteger('arquivo_id')->unsigned();
            $table->foreign('arquivo_id')->references('id')->on('arquivos')->onDelete('cascade');
            
            $table->bigInteger('curso_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');

            $table->primary(['arquivo_id', 'curso_id']);
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
        Schema::table('arquivo_curso', function (Blueprint $table) {
            $table->dropForeign('arquivo_curso_curso_id_foreign');
            $table->dropColumn('curso_id');
            $table->dropForeign('arquivo_curso_arquivo_id_foreign');
            $table->dropColumn('arquivo_id');
        });
        Schema::dropIfExists('arquivo_curso');
    }
}
