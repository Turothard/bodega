<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoscajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresoscaja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("proveedor_id");
            $table->foreign('proveedor_id')->references('rutproveedor')->on('proveedores')->onDelete('cascade');
            $table->string("usering");
            $table->string("nombreproving");
            $table->string("tipodocing");
            $table->string("nrodocing");
            $table->date("fechaingresoing");
            $table->integer("cantidading");
            $table->integer("montoing");
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
        Schema::dropIfExists('ingresoscaja');
    }
}
