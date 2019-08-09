<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestaquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destaques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo', 255)->nullable();
            $table->longText('conteudo')->nullable();
            $table->date('data_exibicao'); //Exibe o Destaque até a data informada
            $table->string('link_url', 255)->nullable(); //Link Externo onde será redirecionado
            $table->integer('ordem')->unsigned();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('imagem_id')->unsigned();
            $table->foreign('imagem_id')->references('id')->on('imagens')->onDelete('cascade');

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
        Schema::table('destaques', function (Blueprint $table) {
            $table->dropForeign('destaques_imagem_id_foreign');
            $table->dropColumn('imagem_id');
            $table->dropForeign('destaques_user_id_foreign');
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('destaques');
    }
}
