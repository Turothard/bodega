<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoordencomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresoordencompras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('nrooc');
            $table->foreign('nrooc')->references('nrooc')->on('ordencompras')->onDelete('cascade');
            $table->unsignedInteger('recep_id');
            $table->foreign('recep_id')->references('id')->on('recepcionocs')->onDelete('cascade');
            $table->string("codigoart");
            $table->integer("cantidadrecep");
            $table->string("bodega_id");
            $table->integer("estante_id");
            $table->integer("sectoring");
            $table->integer("niveling");
            $table->integer("cantidading");
            $table->integer("montounitariodetoc");
            $table->integer("montototaldococ");
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
        Schema::dropIfExists('ingresoordencompras');
    }
}
