<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalletrabajos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('detalleservicio_id');
            $table->foreign('detalleservicio_id')->references('id')->on('detalleservicios')->onDelete('cascade');
            $table->unsignedInteger('serviciotrabajo_id');
            $table->foreign('serviciotrabajo_id')->references('id')->on('serviciotrabajos')->onDelete('cascade');
            $table->timestamp('inicio')->nullable();
            $table->string('fotoinicio')->nullable();
            $table->timestamp('termino');
            $table->string('fototermino')->nullable();
            $table->integer('asistentes')->nullable();
            $table->integer('valorinicial');
            $table->integer('valoragregado')->nullable();
            $table->unsignedInteger('observaciontabulada_id')->nullable();
            $table->foreign('observaciontabulada_id')->references('id')->on('observaciontabuladas')->onDelete('cascade');
            $table->string('obsvaloragregado')->nullable();
            $table->integer('valorfinal');
            $table->unsignedInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalletrabajos');
    }
}
