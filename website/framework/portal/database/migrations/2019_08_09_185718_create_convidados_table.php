<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvidadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convidados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 255);
            $table->string('cpf', 11)->unique();
            $table->string('fone', 15)->nullable();
            $table->enum('sexo', ['M','F']);

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::table('convidados', function (Blueprint $table) {
            $table->dropForeign('convidados_user_id_foreign');
            $table->dropColumn('user_id');                       
        });
        Schema::dropIfExists('convidados');
    }
}
