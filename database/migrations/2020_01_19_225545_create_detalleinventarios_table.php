<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleinventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleinventarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inventario_id');
            $table->foreign('inventario_id')->references('id')->on('inventarios')->onDelete('cascade');
            $table->string('bodega_id');
            $table->string('posicion_id');
            $table->bigInteger('estante_id');
            $table->integer('sectorinv');
            $table->integer('nivelinv');
            $table->string('codigoart');
            $table->integer('cantidadbod');
            $table->integer('cantidadinv');
            $table->integer('cantidaddif');
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
        Schema::dropIfExists('detalleinventarios');
    }
}
