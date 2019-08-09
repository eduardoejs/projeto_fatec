<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscricoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('subevento_id')->unsigned();
            $table->foreign('subevento_id')->references('id')->on('subeventos')->onDelete('cascade');

            $table->enum('liberar_certificado', ['S', 'N'])->default('N'); //Libera certificado ao usuário após verificada a presenca
            
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
        Schema::table('inscricoes', function (Blueprint $table) {
            $table->dropForeign('inscricoes_subevento_id_foreign');
            $table->dropColumn('subevento_id');
            $table->dropForeign('inscricoes_user_id_foreign');
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('inscricoes');
    }
}
