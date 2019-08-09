<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionaPaginaComPerfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagina_perfil', function (Blueprint $table) {
            $table->bigInteger('pagina_id')->unsigned();
            $table->foreign('pagina_id')->references('id')->on('paginas')->onDelete('cascade');

            $table->bigInteger('perfil_id')->unsigned();
            $table->foreign('perfil_id')->references('id')->on('perfis')->onDelete('cascade');

            $table->timestamps();

            $table->primary(['pagina_id', 'perfil_id']);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagina_perfil', function (Blueprint $table) {            
            $table->dropForeign('pagina_perfil_perfil_id_foreign');
            $table->dropColumn('perfil_id');
            $table->dropForeign('pagina_perfil_pagina_id_foreign');
            $table->dropColumn('pagina_id');            
        });
        Schema::dropIfExists('pagina_perfil');
    }
}
