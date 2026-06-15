<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecepcionocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcionocs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('nrooc');
            $table->foreign('nrooc')->references('nrooc')->on('ordencompras')->onDelete('cascade');
            $table->unsignedInteger('doc_id');
            $table->foreign('doc_id')->references('id')->on('documentosordencompras')->onDelete('cascade');
            $table->unsignedInteger('detoc_id');
            $table->foreign('detoc_id')->references('iddetalleoc')->on('detalleordencompras')->onDelete('cascade');
            $table->integer("cantidaddetoc");
            $table->integer("cantidaddococ");
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
        Schema::dropIfExists('recepcionocs');
    }
}
