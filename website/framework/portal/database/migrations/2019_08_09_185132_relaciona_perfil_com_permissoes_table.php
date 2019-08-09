<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionaPerfilComPermissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_permissao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('perfil_id')->unsigned();
            $table->foreign('perfil_id')->references('id')->on('perfis')->onDelete('cascade');

            $table->bigInteger('permissao_id')->unsigned();
            $table->foreign('permissao_id')->references('id')->on('permissoes')->onDelete('cascade'); 
            
            $table->timestamps();
            
            $table->primary(['perfil_id','permissao_id']);             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_permissao');
    }
}
