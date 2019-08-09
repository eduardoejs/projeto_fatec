<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionaArquivoComVestibularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivo_vestibular', function (Blueprint $table) {
            $table->string('titulo', 255)->nullable();
            $table->string('descricao', 255)->nullable();

            $table->bigInteger('arquivo_id')->unsigned();
            $table->foreign('arquivo_id')->references('id')->on('arquivos')->onDelete('cascade');
            
            $table->bigInteger('vestibular_id')->unsigned();
            $table->foreign('vestibular_id')->references('id')->on('vestibulares')->onDelete('cascade');

            $table->timestamps();

            $table->primary(['arquivo_id', 'vestibular_id']);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arquivo_vestibular', function (Blueprint $table) {
            $table->dropForeign('arquivo_vestibular_vestibular_id_foreign');
            $table->dropColumn('vestibular_id');
            $table->dropForeign('arquivo_vestibular_arquivo_id_foreign');
            $table->dropColumn('arquivo_id');
        }); 
        Schema::dropIfExists('arquivo_vestibular');
    }
}
