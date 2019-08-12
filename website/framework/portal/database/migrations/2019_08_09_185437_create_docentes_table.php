<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('nome');
            $table->string('cpf', 11)->unique();            
            $table->enum('sexo', ['M', 'F']);
            $table->string('url_lattes', 255)->nullable();
            $table->string('link_compartilhado', 255)->nullable();
            $table->enum('titulacao', ['B', 'L', 'PG', 'M', 'D']); //Bacharel, Licenciatura, PosGraduado, Mestrado, Doutorado
            $table->enum('exibe_dados', ['S', 'N'])->default('S');
            
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('cargo_id')->unsigned();
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');

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
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropForeign('docentes_cargo_id_foreign');
            $table->dropColumn('cargo_id');
            $table->dropForeign('docentes_user_id_foreign');
            $table->dropColumn('user_id');            
        });
        Schema::dropIfExists('docentes');
    }
}
