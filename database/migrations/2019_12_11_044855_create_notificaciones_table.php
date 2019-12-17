<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("tipo");
            $table->string("tabla");
            $table->string("id_tabla");
            $table->string("destino");
            $table->string("grupo");
            $table->unsignedInteger("userproceso_id");
            $table->foreign('userproceso_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger("userobjetivo_id")->nullable();
            $table->foreign('userobjetivo_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("grupoobjetivo");
            $table->string("mensaje");
            $table->string("estado");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificaciones');
    }
}
