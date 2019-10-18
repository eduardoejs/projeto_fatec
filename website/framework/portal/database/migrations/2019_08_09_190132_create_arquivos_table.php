<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArquivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->longText('descricao')->nullable();
            $table->string('nome_arquivo', 45);
            $table->integer('tamanho_arquivo')->unsigned();
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
        Schema::dropIfExists('arquivo_vestibular');
        Schema::dropIfExists('arquivo_pagina');
        Schema::dropIfExists('arquivo_noticia');
        Schema::dropIfExists('arquivos');
    }
}
