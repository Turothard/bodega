<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posiciones', function (Blueprint $table) {
            $table->bigIncrements('idposicion');
            $table->unsignedBigInteger("estante_id");
            $table->foreign('estante_id')->references('id')->on('estantes')->onDelete('cascade');
            $table->integer("sectorpos");
            $table->integer("nivelpos");
            $table->string("codigoart");
            $table->foreign('codigoart')->references('codigoart')->on('articulos')->onDelete('cascade');
            $table->integer("cantidadpos");
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
        Schema::dropIfExists('posiciones');
    }
}
