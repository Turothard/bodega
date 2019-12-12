<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallepedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallepedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger("pedido_id");
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->string("tipodetped");
            $table->string("codigoart");
            $table->foreign('codigoart')->references('codigoart')->on('articulos')->onDelete('cascade');
            $table->integer("cantidaddetped");
            $table->integer("cantidadprodetped")->nullable();
            $table->integer("cantidaddifdetped")->nullable();
            $table->string("identificadorusodetped")->nullable();
            $table->string("observaciondevodetped")->nullable();
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
        Schema::dropIfExists('detallepedidos');
    }
}
