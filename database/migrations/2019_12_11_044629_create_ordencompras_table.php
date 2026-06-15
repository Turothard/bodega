<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdencomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordencompras', function (Blueprint $table) {
            $table->bigIncrements('nrooc');
            $table->unsignedInteger("categoria_id");
            $table->foreign('categoria_id')->references('idcategoria')->on('categorias')->onDelete('cascade');
            $table->string("proveedor_id");
            $table->foreign('proveedor_id')->references('rutproveedor')->on('proveedores')->onDelete('cascade');
            $table->date("fechaoc");
            $table->integer("cantidadoc");
            $table->integer("montooc");
            $table->string("estadooc");
            $table->unsignedInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('ordencompras');
    }
}
