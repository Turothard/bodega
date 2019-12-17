<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("tipopedido");
            $table->unsignedInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('sector_id');
            $table->foreign('sector_id')->references('idsector')->on('sectores')->onDelete('cascade');
            $table->unsignedInteger('area_id');
            $table->foreign('area_id')->references('idarea')->on('areas')->onDelete('cascade');
            $table->unsignedInteger('ubicacion_id')->nullable();
            $table->foreign('ubicacion_id')->references('idubicacion')->on('ubicaciones')->onDelete('cascade');
            $table->string("preestablecidoped")->nullable();
            $table->integer("cantidadped");
            $table->integer("cantidadproped")->nullable();
            $table->integer("cantidaddifped")->nullable();
            $table->date("fechaped");
            $table->string('autorizado_id')->nullable();
            $table->foreign('autorizado_id')->references('rutcolaborador')->on('colaboradores')->onDelete('cascade');
            $table->string('bodeguero_id')->nullable();
            $table->foreign('bodeguero_id')->references('rutcolaborador')->on('colaboradores')->onDelete('cascade');
            $table->string('receptor_id')->nullable();
            $table->foreign('receptor_id')->references('rutcolaborador')->on('colaboradores')->onDelete('cascade');
            $table->string('estadoped');
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
        Schema::dropIfExists('pedidos');
    }
}
