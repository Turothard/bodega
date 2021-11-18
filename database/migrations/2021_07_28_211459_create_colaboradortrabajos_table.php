<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradorTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colaboradortrabajos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('detalletrabajo_id');
            $table->foreign('detalletrabajo_id')->references('id')->on('detalletrabajos')->onDelete('cascade');
            $table->string("colaborador_id");
            $table->foreign('colaborador_id')->references('rutcolaborador')->on('colaboradores')->onDelete('cascade');
            $table->integer('turno');
            $table->timestamp('horario');
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
        Schema::dropIfExists('colaboradortrabajos');
    }
}
