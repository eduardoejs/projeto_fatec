<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('data');
            $table->integer('termo')->unsigned();
            $table->enum('turno', ['M', 'T', 'N']); //Manha Tarde ou Noite
            $table->enum('tipo', ['L', 'A']);// Livre ou Aula
            $table->tinyInteger('aula1')->nullable();
            $table->tinyInteger('aula2')->nullable();
            $table->tinyInteger('aula3')->nullable();
            $table->tinyInteger('aula4')->nullable();
            $table->tinyInteger('aula5')->nullable();            
            $table->time('horario_inicial')->nullable();
            $table->time('horario_final')->nullable();
            
            $table->bigInteger('agenda_id')->unsigned(); //orientador
            $table->foreign('agenda_id')->references('id')->on('agendas')->onDelete('cascade');

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
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->dropForeign('agendamentos_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropForeign('agendamentos_agenda_id_foreign');
            $table->dropColumn('agenda_id');
        });
        Schema::dropIfExists('agendamentos');
    }
}
