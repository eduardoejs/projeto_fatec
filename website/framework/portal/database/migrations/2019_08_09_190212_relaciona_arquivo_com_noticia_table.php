<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionaArquivoComNoticiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivo_noticia', function (Blueprint $table) {
            $table->string('titulo', 255)->nullable();
            $table->string('descricao', 255)->nullable();

            $table->bigInteger('arquivo_id')->unsigned();
            $table->foreign('arquivo_id')->references('id')->on('arquivos')->onDelete('cascade');
            
            $table->bigInteger('noticia_id')->unsigned();
            $table->foreign('noticia_id')->references('id')->on('noticias')->onDelete('cascade');

            $table->primary(['arquivo_id', 'noticia_id']);
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
        Schema::table('arquivo_noticia', function (Blueprint $table) {
            $table->dropForeign('arquivo_noticia_noticia_id_foreign');
            $table->dropColumn('noticia_id');
            $table->dropForeign('arquivo_noticia_arquivo_id_foreign');
            $table->dropColumn('arquivo_id');
        });
        Schema::dropIfExists('arquivo_noticia');
    }
}
