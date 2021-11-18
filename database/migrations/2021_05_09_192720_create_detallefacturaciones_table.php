<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleFacturacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallefacturaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('facturacion_id');
            $table->foreign('facturacion_id')->references('id')->on('facturaciones')->onDelete('cascade');
            $table->unsignedInteger('tipofacturacion_id');
            $table->foreign('tipofacturacion_id')->references('id')->on('tipofacturaciones')->onDelete('cascade');
            $table->unsignedInteger('sector_id');
            $table->foreign('sector_id')->references('idsector')->on('sectores')->onDelete('cascade');
            $table->integer('mesfacturacion');
            $table->timestamp('fechainicio');
            $table->timestamp('fechatermino');
            $table->unsignedInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('netototal');
            $table->integer('ivatotal');
            $table->integer('brutofinal');
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
        Schema::dropIfExists('detallefacturaciones');
    }
}
