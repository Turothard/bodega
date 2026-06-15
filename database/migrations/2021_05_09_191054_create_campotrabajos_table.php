<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampoTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campotrabajos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('trabajo_id');
            $table->foreign('trabajo_id')->references('id')->on('trabajos')->onDelete('cascade');
            $table->unsignedInteger('campo_id');
            $table->foreign('campo_id')->references('id')->on('campoformularios')->onDelete('cascade');
            $table->string('nombre')->nullable();
            $table->integer('largo')->nullable();
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
        Schema::dropIfExists('campotrabajos');
    }
}
