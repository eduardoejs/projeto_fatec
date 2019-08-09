<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionaArquivoComPaginaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivo_pagina', function (Blueprint $table) {
            $table->bigInteger('arquivo_id')->unsigned();
            $table->foreign('arquivo_id')->references('id')->on('arquivos')->onDelete('cascade');

            $table->bigInteger('pagina_id')->unsigned();
            $table->foreign('pagina_id')->references('id')->on('paginas')->onDelete('cascade');

            $table->timestamps();

            $table->primary(['arquivo_id', 'pagina_id']);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arquivo_pagina', function (Blueprint $table) {
            $table->dropForeign('arquivo_pagina_pagina_id_foreign');
            $table->dropColumn('pagina_id');
            $table->dropForeign('arquivo_pagina_arquivo_id_foreign');
            $table->dropColumn('arquivo_id');
        });
        Schema::dropIfExists('arquivo_pagina');
    }
}
