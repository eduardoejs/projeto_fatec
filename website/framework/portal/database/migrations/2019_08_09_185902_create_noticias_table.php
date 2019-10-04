<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo', 255);
            $table->longText('conteudo');
            $table->date('data_exibicao')->nullable(); //Exibe a noticia até a data informada
            $table->enum('ativo', ['S','N'])->default('S');
            
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
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
        Schema::table('noticias', function (Blueprint $table) {
            $table->dropForeign('noticias_user_id_foreign');
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('imagem_noticia');
        Schema::dropIfExists('noticias');
    }
}
