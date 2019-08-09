<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionaCursosComEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_evento', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('evento_id')->unsigned();
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');

            $table->bigInteger('curso_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            
            $table->timestamps();

            //$table->primary(['id', 'curso_id', 'evento_id']);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curso_evento', function (Blueprint $table) {
            $table->dropForeign('curso_evento_curso_id_foreign');
            $table->dropColumn('curso_id');
            $table->dropForeign('curso_evento_evento_id_foreign');
            $table->dropColumn('evento_id');
        });
        Schema::dropIfExists('curso_evento');
    }
}
