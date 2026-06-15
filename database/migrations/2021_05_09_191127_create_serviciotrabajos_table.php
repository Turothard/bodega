<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serviciotrabajos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('servicio_id');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->unsignedInteger('trabajo_id');
            $table->foreign('trabajo_id')->references('id')->on('trabajos')->onDelete('cascade');
            $table->unsignedInteger('tipofacturacion_id');
            $table->foreign('tipofacturacion_id')->references('id')->on('tipofacturaciones')->onDelete('cascade');
            $table->boolean('multiplicador')->nullable();
            $table->unsignedInteger('campo_id')->nullable();
            $table->foreign('campo_id')->references('id')->on('campotrabajos')->onDelete('cascade');
            $table->date('caducidad');
            $table->boolean('activo');
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
        Schema::dropIfExists('serviciotrabajos');
    }
}
