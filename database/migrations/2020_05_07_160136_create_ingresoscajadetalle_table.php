<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoscajadetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresoscajadetalle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("ingresocaja_id");
            $table->foreign('ingresocaja_id')->references('id')->on('ingresoscaja')->onDelete('cascade');
            $table->bigInteger("posicion_id");
            $table->string("codigoart");
            $table->string("bodega_id");
            $table->integer("estante_id");
            $table->integer("sectoring");
            $table->integer("niveling");
            $table->integer("cantidading");
            $table->integer("precioing");
            $table->integer("totaling");
            $table->timestamp("fechaing");
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
        Schema::dropIfExists('ingresoscajadetalle');
    }
}
