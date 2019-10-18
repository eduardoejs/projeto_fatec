<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionaImagensComNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagem_noticia', function (Blueprint $table) {
            //$table->string('titulo', 255)->nullable();
            //$table->string('descricao', 255)->nullable();
            
            $table->bigInteger('noticia_id')->unsigned();
            $table->foreign('noticia_id')->references('id')->on('noticias')->onDelete('cascade');

            $table->bigInteger('imagem_id')->unsigned()->nullable();
            $table->foreign('imagem_id')->references('id')->on('imagens')->onDelete('cascade');

            $table->integer('ordem')->unsigned(); //ordem de exibicao das imagens. A 1ª será capa 

            $table->timestamps();

            //$table->primary(['noticia_id', 'imagem_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imagem_noticia', function (Blueprint $table) {
            $table->dropForeign('imagem_noticia_imagem_id_foreign');
            $table->dropColumn('imagem_id');
            $table->dropForeign('imagem_noticia_noticia_id_foreign');
            $table->dropColumn('noticia_id');
        });
        Schema::dropIfExists('imagem_noticia');
    }
}
