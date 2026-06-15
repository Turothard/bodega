<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallepedposicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallepedposiciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger("detallepedido_id");
            $table->foreign('detallepedido_id')->references('id')->on('detallepedidos')->onDelete('cascade');
            $table->string("codigoart");
            $table->foreign('codigoart')->references('codigoart')->on('articulos')->onDelete('cascade');
            $table->bigInteger("posicion_id");
            $table->foreign('posicion_id')->references('idposicion')->on('posiciones')->onDelete('cascade');
            $table->integer("cantidadpedido");
            $table->integer("cantidadproceso")->nullable();
            $table->integer("cantidaddevolucion")->nullable();
            $table->string('receptor_prod')->nullable();
            $table->foreign('receptor_prod')->references('rutcolaborador')->on('colaboradores')->onDelete('cascade');
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
        Schema::dropIfExists('detallepedposiciones');
    }
}
