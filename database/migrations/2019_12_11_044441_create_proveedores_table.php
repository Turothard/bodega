<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->string('rutproveedor');
            $table->primary('rutproveedor');
            $table->string('nombreprov');
            $table->string('codigoprov');
            $table->string('giroprov');
            $table->string('comunaprov');
            $table->string('direccionprov');
            $table->string('telefonoprov');
            $table->string('correoprov');
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
        Schema::dropIfExists('proveedores');
    }
}
