<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategorias', function (Blueprint $table) {
            $table->bigIncrements('idsubcategoria');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('idcategoria')->on('categorias')->onDelete('cascade');
            $table->string("codigosubcat");
            $table->string("nombresubcat");
            $table->string("descripcionsubcat")->nullable();
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
        Schema::dropIfExists('subcategorias');
    }
}
