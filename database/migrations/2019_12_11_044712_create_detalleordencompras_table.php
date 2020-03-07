<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleordencomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleordencompras', function (Blueprint $table) {
            $table->bigIncrements('iddetalleoc');
            $table->unsignedInteger('ordencompra_id');
            $table->foreign('ordencompra_id')->references('nrooc')->on('ordencompras')->onDelete('cascade');
            $table->string("articulodetoc");
            $table->string("codigoart")->nullable();
            $table->foreign('codigoart')->references('codigoart')->on('articulos')->onDelete('cascade');
            $table->string("bodega_id");
            $table->foreign('bodega_id')->references('idbodega')->on('bodegas')->onDelete('cascade');
            $table->unsignedInteger('sector_id');
            $table->foreign('sector_id')->references('idsector')->on('sectores')->onDelete('cascade');
            $table->string("colordetoc");
            $table->string("color_id")->nullable();
            $table->foreign('color_id')->references('idcolor')->on('colores')->onDelete('cascade');
            $table->string("marca_id");
            $table->foreign('marca_id')->references('idmarca')->on('marcas')->onDelete('cascade');
            $table->string("unidad_id");
            $table->foreign('unidad_id')->references('idunidad')->on('unidades')->onDelete('cascade');
            $table->integer("cantidaddetoc");
            $table->integer("cantidadrecoc")->nullable();
            $table->integer("montounitariodetoc");
            $table->integer("montototaldetoc");
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
        Schema::dropIfExists('detalleordencompras');
    }
}
