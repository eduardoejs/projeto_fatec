<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVestibularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vestibulares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('conteudo');
            $table->decimal('valor_inscricao', 8,2);
            $table->date('data_inicio'); //Data de início das inscricoes
            $table->date('data_fim'); //Data final das inscricoes
            $table->date('data_exibicao'); //Exibe as informacoes de vestibular até a data informada

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
        Schema::table('vestibulares', function (Blueprint $table) {
            $table->dropForeign('vestibulares_imagem_id_foreign');
            $table->dropColumn('imagem_id');
        }); 
        Schema::dropIfExists('vestibulares');
    }
}
