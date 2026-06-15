<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->string('codigoart');
            $table->primary('codigoart');
            $table->string('codigoalternativoart')->nullable();;
            $table->unsignedInteger('categoria_id');
            $table->foreign('categoria_id')->references('idcategoria')->on('categorias')->onDelete('cascade');
            $table->unsignedInteger('subcategoria_id');
            $table->foreign('subcategoria_id')->references('idsubcategoria')->on('subcategorias')->onDelete('cascade');
            $table->string('nombreart');
            $table->string('proveedorart');
            $table->string('descripcionart');
            $table->string('color_id');
            $table->foreign('color_id')->references('idcolor')->on('colores')->onDelete('cascade');
            $table->string('unidad_id');
            $table->foreign('unidad_id')->references('idunidad')->on('unidades')->onDelete('cascade');
            $table->string('marca_id');
            $table->foreign('marca_id')->references('idmarca')->on('marcas')->onDelete('cascade');
            $table->integer("stockcriticoart")->nullable();
            $table->integer("indicerotacionart")->nullable();
            $table->integer("yearart");
            $table->unsignedInteger('periododevo_id');
            $table->foreign('periododevo_id')->references('idperiodo')->on('periodosdevos')->onDelete('cascade');
            $table->string("image")->nullable();;
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
        Schema::dropIfExists('articulos');
    }
}
