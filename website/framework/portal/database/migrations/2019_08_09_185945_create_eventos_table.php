<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 255);
            $table->longText('descricao')->nullable();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->enum('liberar_certificados', ['S','N'])->default('N'); //Habilita o botão/visualizacao para certificados
            $table->date('data_limite_inscricoes'); //Data limite para inscricoes
            $table->enum('ativo', ['S','N'])->default('N'); //Inicialmente o evento fica Inativo

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
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign('eventos_imagem_id_foreign');
            $table->dropColumn('imagem_id');
        });
        Schema::dropIfExists('inscricoes');
        Schema::dropIfExists('curso_evento');
        Schema::dropIfExists('eventos');
    }
}
