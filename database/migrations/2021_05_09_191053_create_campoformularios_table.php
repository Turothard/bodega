<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampoFormulariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campoformularios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo');
            $table->string('tipoformulario');
            $table->string('tipoinforme');
            $table->string('nombre');
            $table->string('tipovalor')->nullable();
            $table->string('valor')->nullable();
            $table->boolean('extensible')->nullable();
            $table->boolean('requerido');
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
        Schema::dropIfExists('campoformularios');
    }
}
